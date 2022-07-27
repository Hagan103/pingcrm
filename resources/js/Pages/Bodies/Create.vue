<template>
  <div>
    <div class="absolute">
      <Head title="Create Organization"/>
      <h1 class="mb-8 text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/organizations">Bodies</Link>
        <span class="text-indigo-400 font-medium">/</span> Create
      </h1>
      <div class="max-w-md bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="store">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-full" label="Name"/>
            <text-input type="number" v-model="form.body_fat_percentage" :error="form.errors.body_fat_percentage"
                        class="pb-8 pr-6 w-full lg:w-full"
                        label="Fat percentage"/>
            <text-input type="number" v-model="form.weight" :error="form.errors.weight" class="pb-8 pr-6 w-full lg:w-full"
                        label="Weight"/>
            <text-input type="number" v-model="form.height" :error="form.errors.height" class="pb-8 pr-6 w-full lg:w-full"
                        label="Height"/>
            <text-input type="number" v-model="form.age" :error="form.errors.age" class="pb-8 pr-6 w-full lg:w-full" label="Age"/>
          </div>
          <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
            <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Body</loading-button>
          </div>
        </form>
      </div>
    </div>

    <div id="container" class=""></div>

  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

import * as THREE from "three";
import {WebGLRenderer} from "three";
import Stats from '../../../../node_modules/three/examples/jsm/libs/stats.module'
import {GUI} from 'dat.gui'
import {OrbitControls} from '../../../../node_modules/three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from '../../../../node_modules/three/examples/jsm/loaders/GLTFLoader'


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
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        body_fat_percentage: 20,
        weight: 75,
        height: 180,
        age: 25,
      }),

      // camera: null,
      // scene: null,
      // renderer: null,
      // object: null,
      // composer: null,
      //
      // stats: null,
      // clock: null,
      // gui: null,
      // mixer: null,
      // actions: null,
      // controls: null,
      // face: null,
      //
      // container: null,
      // neck: null,
      // waist: null,
      // fileAnimations: null,
      // idle: null,
      // neckMixer: null,
      // possibleAnims: null,
      // dirLight: null,
    }
  },
  mounted() {
    this.init();
    this.animate();
  },
  methods: {
    store() {
      this.form.post('/bodies')
    },
    init() {
      this.container =  document.getElementById('container');




      this.camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.25, 100);
      this.camera.position.set(0, 0, 8);
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
      loader.load('../../../models/morph-t-pose.glb',  (gltf) => {
        this.model = gltf.scene;
        this.model.scale.set(0.03, 0.03, 0.03);
        // model.rotation.y = Math.PI / 2;
        this.scene.add(this.model);
        this.model.castShadow = false;
        this.model.position.set(1, 1, 1);
        this.fileAnimations = gltf.animations;
        this.face = this.model.getObjectByName('Human').getObjectByName('human')
        // this.face.morphTargetInfluences[0] = 1000;
        this.createGUI(this.model, gltf.animations);
      }, undefined, function (e) {
        console.error(e);
      });


      this.renderer = new THREE.WebGLRenderer({antialias: true});
      this.renderer.setPixelRatio(window.devicePixelRatio);
      this.renderer.setSize(window.innerWidth, window.innerHeight);
      this.renderer.outputEncoding = THREE.sRGBEncoding;
      this.renderer.shadowMap.enabled = true;
      this.renderer.shadowMap.type = THREE.VSMShadowMap;

      this.controls = new OrbitControls(this.camera, this.renderer.domElement);

      this.controls.update();

      this.container.appendChild(this.renderer.domElement);



      window.addEventListener('resize', (this.onWindowResize));
      this.onWindowResize();

      // stats
      this.stats = new Stats();
      this.container.appendChild(this.stats.dom);
    },

    createGUI(model, animations) {

      const states = ['idle'];
      // const emotes = [ 'Jump', 'Yes', 'No', 'Wave', 'Punch', 'ThumbsUp' ];

      this.gui = new GUI();

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
      model.position.setY(-3);

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
      const expressionFolder = this.gui.addFolder('Expressions');
      console.log('morphTargetInfluences', this.face.morphTargetInfluences);
      console.log('morps,', this.face.morphTargetInfluences);
      for (let i = 0; i < expressions.length; i++) {

        expressionFolder.add(this.face.morphTargetInfluences, i, 0, 1, 0.01).name(expressions[i]);

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

      console.log('fileAnimations', this.fileAnimations);
      // let idleAnim = THREE.AnimationClip.findByName(this.fileAnimations, 'idle_Stacy.001');
      // console.log('idleAnim', idleAnim);
      // idleAnim.tracks.splice(3, 3);
      // idleAnim.tracks.splice(9, 3);
      // this.idle = this.mixer.clipAction(idleAnim);
      // console.log('idle', this.idle)
      // // idle.timeScale = 2;
      //
      // this.idle.play();

      expressionFolder.open();


      // initPostprocessing();


    },


    render() {

    },


    onWindowResize() {

      this.camera.aspect = document.getElementById('container').firstChild.clientWidth / document.getElementById('container').firstChild.clientHeight;
      this.camera.updateProjectionMatrix();

      this.renderer.setSize(document.getElementById('container').firstChild.clientWidth, document.getElementById('container').firstChild.clientHeight);

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
      var weigh = this.form.weight;
      var age = this.form.age
      let fatInfluence = (fat * 2.5);


      console.log('weigh', weigh);

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

        this.face.morphTargetInfluences[3] = age /100;

        let m2 = height / 100;

        let ffm = weigh * (1 - (fat));
        let ffmi = ffm / (m2 * m2);
        this.face.morphTargetInfluences[2] = (ffmi / 100) * 3

        console.log('this.face.morphTargetInfluences[2]', this.face.morphTargetInfluences[2]);

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
        this.controls.update();

      }

      this.renderer.render(this.scene, this.camera);

      this.stats.update();
    }
  }
}
</script>
