<template>
  <div class="flex flex-col h-screen">
    <div id="container" class="grow w-full h-full"></div>

    <div class="max-w-md bg-white rounded-md shadow overflow-hidden hidden">
      <!--      <form @submit.prevent="store">-->
      <!--        <div class="flex flex-wrap -mb-8 -mr-6 p-8">-->
      <!--          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-full" label="Name"/>-->
      <!--          <text-input type="number" v-model="form.body_fat_percentage" :error="form.errors.body_fat_percentage"-->
      <!--                      class="pb-8 pr-6 w-full lg:w-full"-->
      <!--                      label="Fat percentage"/>-->
      <!--          <text-input type="number" v-model="form.weight" :error="form.errors.weight" class="pb-8 pr-6 w-full lg:w-full"-->
      <!--                      label="Weight"/>-->
      <!--          <text-input type="number" v-model="form.height" :error="form.errors.height" class="pb-8 pr-6 w-full lg:w-full"-->
      <!--                      label="Height"/>-->
      <!--          <text-input type="number" v-model="form.age" :error="form.errors.age" class="pb-8 pr-6 w-full lg:w-full"-->
      <!--                      label="Age"/>-->
      <!--        </div>-->
      <!--        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">-->
      <!--          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Body</loading-button>-->
      <!--        </div>-->
      <!--      </form>-->
    </div>
    <div>
      <div class="relative bg-white rounded-t-3xl">
        <div class="w-full flex justify-center py-5">
        <h1 class="text-xl font-bold">
          {{ steps[step-1].title }}
        </h1>
        </div>
        <div style="height: 160px;">
          <Transition name="slide-up" mode="out-in">
            <ScrollInput key="weightInput"
                         v-if="step == 1"
                         unit="kg"
                         min="30"
                         max="300"
                         label="weight"
                         :value="weight"
                         @input="e => weight = e"
            />

            <ScrollInput key="fatInput"
                         v-else-if="step == 2"
                         min="10" max="99"
                         label="bodyfat"
                         :value="form.body_fat_percentage"
                         @input="e => form.body_fat_percentage = e"
            />
          </Transition>
        </div>

        <!--        <transition name="fade">-->
        <!--          <ScrollInput-->
        <!--            style="height: 160px;"-->
        <!--            :key="inputview"-->
        <!--            :min="stepInputProp.min"-->
        <!--            :max="stepInputProp.max"-->
        <!--            :label="stepInputProp.label"-->
        <!--            :value="stepInputProp.value"-->
        <!--            @input="e => form.body_fat_percentage = e"-->
        <!--          />-->
        <!--        </transition>-->

        <div class="relative z-50 pb-4 pt-10 flex justify-center space-x-4">
          <button @click="prev"
                  :disable="step === steps.length"
                  type="button"
                  class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            back
          </button>
          <button @click="next"
                  :disable="step === steps.length"
                  type="button"
                  class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Continue
          </button>

        </div>
      </div>

      <!--    <div class="w-full flex justify-center  font-bold">-->
      <!--      {{ weight }}-->
      <!--    </div>-->
    </div>
  </div>

</template>

<script>
import Flickity from "flickity";
import * as THREE from "three";
import {GLTFLoader} from "three/examples/jsm/loaders/GLTFLoader";
import {OrbitControls} from "three/examples/jsm/controls/OrbitControls";
import Stats from "three/examples/jsm/libs/stats.module";
import {GUI} from "dat.gui";

import('flickity/dist/flickity.css');

import ScrollInput from "@/Pages/Bodies/components/ScrollInput";

let container, stats, clock, gui, mixer, actions, controls;
let camera, scene, renderer, model, face;

const api = {state: 'Walking'};

let neck, waist;
let fileAnimations;
let idle;
let neckMixer;
let possibleAnims;

let dirLight, spotLight;

let width = window.innerWidth;
let height = window.innerHeight;

var treadmill;

export default {
  components: {
    ScrollInput,
  },
  data() {
    return {
      step: 1,

      steps: [
        {
          id: 1,
          title: "Weight",
        },
        {
          id: 2,
          title: "Body Fat %",
        },
        {
          id: 3,
          title: "Height",
        },
        {
          id: 4,
          title: "Age",
        },
      ],

      weight: 75,
      form: this.$inertia.form({
        name: null,
        body_fat_percentage: 20,
        weight: 75,
        height: 180,
        age: 25,
      }),
    };
  },
  mounted() {
    this.init();
    this.animate();

  },
  computed: {
    componentData() {
      return {

        'weight-input': {
          name: ScrollInput,
          props: {unit: "kg", min: "30", max: "300", label: "weight", value: this.weight},
          id: 1,
          on: {
            input: (e) => {
              this.weight = e
            }
          }
        },
        'bodyfat-input': {
          name: ScrollInput,
          props: {min: "10", max: "99", label: "bodyfat", value: 99},
          id: 1,
          on: {
            input: (e) => {
              this.form.body_fat_percentage = e
            }
          }
        },
      }
    },
    stepInputProp() {
      return this.componentData[this.inputview].props;
    },
    inputview() {
      return [
        'weight-input',
        'bodyfat-input',
      ][this.step - 1]
    }
  },
  methods: {
    prev() {
      if (this.step > 1) {
        this.step = this.step - 1;
      }
    },
    next() {
      if (this.step < this.steps.length) {
        this.step = this.step + 1;
      }
    },
    init() {
      this.container = document.getElementById('container');


      this.camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.25, 100);
      this.camera.position.set(0, 0, 5);
      this.camera.lookAt(new THREE.Vector3(0, 0, 0));

      this.scene = new THREE.Scene();
      this.scene.background = null;

      this.clock = new THREE.Clock();


      const AmbientLight = new THREE.AmbientLight(0x0c0d12,);
      AmbientLight.position.set(0, 0, 0);
      AmbientLight.intensity = 1;
      this.scene.add(AmbientLight);

      const AmbientLight2 = new THREE.AmbientLight(0x222222,);
      AmbientLight2.position.set(0, 0, 0);
      AmbientLight2.intensity = 2;
      this.scene.add(AmbientLight2);

      let spotLight2 = new THREE.SpotLight(0xadbccf);
      spotLight2.angle = Math.PI / 5;
      spotLight2.penumbra = 0.3;
      spotLight2.position.set(1, 30, -20);
      spotLight2.castShadow = true;
      spotLight2.shadow.camera.near = 10;
      spotLight2.shadow.camera.far = 100;
      spotLight2.shadow.mapSize.width = 1024;
      spotLight2.shadow.mapSize.height = 1024;
      spotLight2.shadow.bias = -0.0001;
      spotLight2.shadow.radius = 4;
      spotLight2.shadow.blurSamples = 20;
      this.scene.add(spotLight2);

      let dirLight = new THREE.DirectionalLight(0xffffff);
      dirLight.position.set(-11.980, 10, 3.920);
      dirLight.castShadow = false;
      dirLight.intensity = 0.64;
      this.scene.add(dirLight);

      let dirLight2 = new THREE.DirectionalLight(0xffffff);
      dirLight2.position.set(200, 195.600, -110.940);
      dirLight2.castShadow = false;
      dirLight2.intensity = 1.10;
      dirLight.shadow.camera.near = 0.1;
      dirLight.shadow.camera.far = 500;
      dirLight.shadow.camera.right = 17;
      dirLight.shadow.camera.left = -17;
      dirLight.shadow.camera.top = 17;
      dirLight.shadow.camera.bottom = -17;
      dirLight.shadow.mapSize.width = 512;
      dirLight.shadow.mapSize.height = 512;
      dirLight.shadow.bias = -0.0005;
      dirLight.shadow.radius = 4;
      dirLight.shadow.blurSamples = 8;
      this.scene.add(dirLight2);


      const geometry = new THREE.PlaneGeometry(2000, 2000);
      geometry.rotateX(-Math.PI / 2);

      const material = new THREE.ShadowMaterial({
        color: 0x000000, transparent: true, opacity: 0.23
      })

      const plane = new THREE.Mesh(geometry, material);
      plane.position.y = -1.5;
      plane.receiveShadow = true;
      this.scene.add(plane);

      const grid = new THREE.GridHelper(60, 20, 0xFFFFFF, 0xFFFFFF);
      grid.material.opacity = 0.2;
      grid.material.transparent = true;
      // scene.add( grid );

      // model
      const loader = new GLTFLoader();
      loader.load('../../../models/morph-t-pose.glb', (gltf) => {
        this.model = gltf.scene;
        this.model.scale.set(0.03, 0.03, 0.03);
        // model.rotation.y = Math.PI / 2;
        this.scene.add(this.model);
        this.model.castShadow = false;
        this.model.position.set(0, 0, 0);
        this.fileAnimations = gltf.animations;
        this.face = this.model.getObjectByName('Human').getObjectByName('human')
        // this.face.morphTargetInfluences[0] = 1000;
        this.createGUI(this.model, gltf.animations);
      }, undefined, function (e) {
        console.error(e);
      });


      this.renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
      this.renderer.setPixelRatio(window.devicePixelRatio);
      this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
      this.renderer.outputEncoding = THREE.sRGBEncoding;
      this.renderer.shadowMap.enabled = true;
      this.renderer.shadowMap.type = THREE.VSMShadowMap;

      // this.controls = new OrbitControls(this.camera, this.renderer.domElement);

      // this.controls.update();

      this.container.appendChild(this.renderer.domElement);


      window.addEventListener('resize', (this.onWindowResize));
      this.onWindowResize();

      // stats
      // this.stats = new Stats();
      // this.container.appendChild(this.stats.dom);
    },

    createGUI(model, animations) {

      const states = ['idle'];
      // const emotes = [ 'Jump', 'Yes', 'No', 'Wave', 'Punch', 'ThumbsUp' ];

      // this.gui = new GUI();

      this.mixer = new THREE.AnimationMixer(model);

      let actions = {};

      console.log('azzz', model);
      this.face = model.getObjectByName('Human').getObjectByName('human')


      let stacy_mtl = new THREE.MeshPhongMaterial({
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 1,
        skinning: true,
        // color: 0xff0000,
        shininess: 60,
        specular: 0x111111
      });

      let blackMat = new THREE.MeshPhongMaterial({
        color: 0x07080b,
        side: THREE.DoubleSide,
        reflectivity: 1,
        // color: 0xff0000,
        shininess: 1.38,
        specular: 0x111111
        // color: 0xff0000,
        // shininess: 150,
        // specular: 0x222222
      });
      model.position.setX(0);
      model.position.setZ(0);
      model.position.setY(-4);

      // model.rotation.y -= -0.2;

      model.traverse(o => {
        // console.log('o', o);
        // // Reference the neck and waist bones
        //
        //
        // if (o.isSkinnedMesh) {
        //
        //   console.log('isSkinnedMesh');
        //   o.material.skinning = true;
        //   console.log('isSkinnedMesh after', o);
        //   o.material = stacy_mtl;
        // }
        // if (o.isMesh) {
        //
        //   o.castShadow = false;
        //   o.receiveShadow = false;
        //   o.material = stacy_mtl;
        //   // character = o;
        //   console.log('o.name', o.name);
        //   if (o.name == "MiConvcom__New_Jog_Forma") {
        //     treadmill = o;
        //     treadmill.material = blackMat;
        //   }
        // }
        //
        // if (o.isBone && o.name === 'mixamorigNeck') {
        //   console.log('o', o);
        //
        //   this.neck = o;
        //   this.neck.position.setY(this.neck.position.y - 1)
        // }
        // if (o.isBone && o.name === 'mixamorigSpine') {
        //   this.waist = o;
        // }

      });


      const expressions = Object.keys(this.face.morphTargetDictionary);
      // const expressionFolder = this.gui.addFolder('Expressions');
      // console.log('morphTargetInfluences', this.face.morphTargetInfluences);
      // console.log('morps,', this.face.morphTargetInfluences);
      for (let i = 0; i < expressions.length; i++) {

        // expressionFolder.add(this.face.morphTargetInfluences, i, 0, 1, 0.01).name(expressions[i]);

      }

      this.neckMixer = new THREE.AnimationMixer(model);
      let clips = this.fileAnimations.filter(val => val.name !== 'idle_Stacy.001');
      this.possibleAnims = clips.map(val => {
          let clip = THREE.AnimationClip.findByName(clips, val.name);

          clip.tracks.splice(3, 3);
          clip.tracks.splice(9, 3);

          clip = this.mixer.clipAction(clip);
          return clip;
        }
      );

      // console.log('fileAnimations', this.fileAnimations);
      // let idleAnim = THREE.AnimationClip.findByName(this.fileAnimations, 'idle_Stacy.001');
      // console.log('idleAnim', idleAnim);
      // idleAnim.tracks.splice(3, 3);
      // idleAnim.tracks.splice(9, 3);
      // this.idle = this.mixer.clipAction(idleAnim);
      // console.log('idle', this.idle)
      // // idle.timeScale = 2;
      //
      // this.idle.play();

      // expressionFolder.open();


      // initPostprocessing();


    },


    render() {

    },


    onWindowResize() {

      this.camera.aspect = document.getElementById('container').firstChild.clientWidth / document.getElementById('container').firstChild.clientHeight;
      this.camera.updateProjectionMatrix();

      this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);

    },

    // let hitFatTarget = false;
    // let hitBaseTarget = []
    // let hitFemaleTarget = false;
    // let hitMuscleTarget = false;
    // let hitSkinnyTarget = false;
    //
    // let randomMorphIndex = 0;
    //
    // let goUp = true;
    // let goDown = false;

    animate() {


      var fat = this.form.body_fat_percentage / 100;
      var height = this.form.height;
      var weigh = this.weight;
      var age = this.form.age
      let fatInfluence = (fat * 2.5);


      // console.log('weigh', weigh);

      if (this.model) {
        this.face = this.model.getObjectByName('Human').getObjectByName('human')
        //
        this.face.morphTargetInfluences[0] = 0
        this.face.morphTargetInfluences[1] = 0;
        this.face.morphTargetInfluences[2] = 0;
        this.face.morphTargetInfluences[3] = 0;
        this.face.morphTargetInfluences[4] = 0;

        if (fatInfluence >= 0.5) {
          this.face.morphTargetInfluences[0] = (fatInfluence - 0.5) * 2;
        } else {
          this.face.morphTargetInfluences[4] = (Math.abs(fatInfluence - 0.5) * 2) * 1.5;
        }

        this.face.morphTargetInfluences[3] = age / 100;

        let m2 = height / 100;

        let ffm = weigh * (1 - (fat));
        let ffmi = ffm / (m2 * m2);
        this.face.morphTargetInfluences[2] = (ffmi / 100) * 3

        // console.log('this.face.morphTargetInfluences[2]', this.face.morphTargetInfluences[2]);

        // let weight = (fat * 100) * (m2 * m2);

        // document.getElementById( "weight" ).innerHTML = weight;

        const expressions = Object.keys(this.face.morphTargetDictionary);
        // //
        // //
        // //   // console.log('face.morphTargetInfluences', face.morphTargetInfluences);
        // //   //
        // //   // face.morphTargetInfluences[0] = fat;
        // //   // const expressionFolder = gui.addFolder( 'Expressions' );
        // //   // console.log('face.morphTargetInfluences[0]',face.morphTargetInfluences[0]);
        // //   // for ( let i = 0; i < expressions.length; i ++ ) {
        // //   //
        // //   //     expressionFolder.add( face.morphTargetInfluences, i, 0, 1, 0.01 ).name( expressions[ i ] );
        // //   //
        // //   // }
        // //   //
        // //   // neckMixer = new THREE.AnimationMixer(model);
        // //   // let clips = fileAnimations.filter(val => val.name !== 'idle_Stacy.001');
        // //   // possibleAnims = clips.map(val => {
        // //   //         let clip = THREE.AnimationClip.findByName(clips, val.name);
        // //   //
        // //   //         clip.tracks.splice(3, 3);
        // //   //         clip.tracks.splice(9, 3);
        // //   //
        // //   //         clip = mixer.clipAction(clip);
        // //   //         return clip;
        // //   //     }
        // //   // );
        // //   //
        // //   // console.log('fileAnimations', fileAnimations);
        // //   // let idleAnim = THREE.AnimationClip.findByName(fileAnimations, 'idle_Stacy.001');
        // //   // console.log('idleAnim', idleAnim);
        // //   // idleAnim.tracks.splice(3, 3);
        // //   // idleAnim.tracks.splice(9, 3);
        // //   // idle = mixer.clipAction(idleAnim);
      }


      const dt = this.clock.getDelta();


      if (this.mixer) this.mixer.update(dt);

      requestAnimationFrame(this.animate);
      if (this.controls) {
        // this.controls.update();

      }

      this.renderer.render(this.scene, this.camera);

      // this.stats.update();
    },
    flickityHandleWheelEvent(e, flickity_instance) {
      // do not trigger a slide change if another is being animated
      // pick the larger of the two delta magnitudes (x or y) to determine nav direction
      var direction = (Math.abs(e.deltaX) > Math.abs(e.deltaY)) ? e.deltaX : e.deltaY;

      console.log("wheel scroll ", e.deltaX, e.deltaY, direction);

      if (direction > 0) {
        // next slide
        flickity_instance.next();
      } else {
        // prev slide
        flickity_instance.previous();
      }
    }
  },
  // watch: {
  //   flkty: {
  //     handler: function (newFlkty) {
  //       console.log('newFlkty', newFlkty.selectedIndex);
  //     },
  //     deep: true
  //   }
  // }
};
</script>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.25s ease-out;
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}

/*.fade-enter-active,*/
/*.fade-leave-active {*/
/*  transition: opacity 0.5s ease;*/
/*}*/

/*.fade-enter-from,*/
/*.fade-leave-to {*/
/*  opacity: 0;*/
/*}*/

/* external css: flickity.css */
.weight-value {
  font-smoothing: antialiased;
  -webkit-font-smoothing: antialiased;
  -webkit-backface-visibility: hidden;
  /*-webkit-transform: translateZ(0px);*/

}

* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
}

.carousel {
  /*background: #FAFAFA;*/
  /*margin-bottom: 2rem;*/
}

/*.carousel-cell {*/
/*  width: 10%;*/
/*  height: 200px;*/
/*  margin-right: 10px;*/
/*  background: #8C8;*/
/*  border-radius: 5px;*/
/*  !*counter-increment: carousel-cell;*!*/
/*}*/

/* cell number */
.carousel-cell:before {
  display: block;
  text-align: center;
  /*content: counter(carousel-cell);*/
  line-height: 200px;
  font-size: 80px;
  color: white;
}

</style>
