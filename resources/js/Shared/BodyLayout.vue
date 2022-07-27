<template>
  <div>
    <div class="container" style="background: rgb(76,76,88);
background: linear-gradient(0deg, rgba(76,76,88,1) 0%, rgba(51,51,66,1) 100%);">
      <div class="slider-wall">
        <div class="slider-wall-top"></div>
        <div class="slider-wall-bottom"></div>
      </div>
      <div class="slider flex justify-center items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white transform rotate-90" viewBox="0 0 20 20"
             fill="currentColor">
          <path fill-rule="evenodd"
                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                clip-rule="evenodd"/>
        </svg>
      </div>
    </div>

    <div class="flex flex-col h-screen w-screen">

      <div class="flex-grow relative pointer-events-none">
        <div class="absolute grid grid-cols-2 h-full p-3 pointer-events-none w-screen z-10">
          <div class="flex justify-start">
            <div>
              <div class="text-sm text-gray-300 text-center mb-1 opacity-70">
                BEFORE
              </div>
              <div class="bg-white rounded-md p-3 w-20 bg-opacity-10 max-w-min">
                <div class="text-xs text-gray-200 text-center mb-0. whitespace-nowrap">
                  Weight
                </div>
                <div>
                  <span class="text-2xl font-bold text-white">{{ Math.round(body.weight) }} </span>

                  <span class="text-gray-200 text-sm pl-1">Kg</span>
                </div>
              </div>

              <div class="bg-white rounded-md p-3 w-20 bg-opacity-10 max-w-min mt-2">
                <div class="text-xs text-gray-200 text-center mb-0.5 whitespace-nowrap">
                  Body Fat
                </div>
                <div>
                  <span class="text-2xl font-bold text-white">{{ Math.round(body.body_fat_percentage) }} </span>

                  <span class="text-gray-200 text-sm pl-1">%</span>
                </div>
              </div>
            </div>
          </div>

          <div class="flex justify-end flex-col items-end">
            <div>
              <div class="text-sm text-gray-300 text-center mb-1 opacity-70 whitespace-nowrap	">
                AFTER
              </div>
              <div class="bg-white rounded-md p-3 w-20 bg-opacity-10 max-w-min">
                <div class="text-xs text-gray-200 text-center mb-0.5 whitespace-nowrap">
                  Weight
                </div>
                <div>
                  <span class="text-2xl font-bold text-white">{{ Math.round(newBody.weight) }} </span>

                  <span class="text-gray-200 text-sm pl-1">Kg</span>
                </div>
              </div>

              <div class="bg-white rounded-md p-3 w-20 bg-opacity-10 max-w-min mt-2">
                <div class="text-xs text-gray-200 text-center mb-0.5 whitespace-nowrap">
                  Body Fat
                </div>
                <div>
                  <span class="text-2xl font-bold text-white">{{ Math.round(newBody.body_fat_percentage) }} </span>

                  <span class="text-gray-200 text-sm pl-1">%</span>
                </div>
              </div>

            </div>
            <div class="flex flex-grow items-end justify-end">
              <div class="h-12 w-12 rounded-full bg-white"></div>
            </div>
          </div>
        </div>

        <div class="pointer-events-auto">
          <transition name="page" mode="out-in" appear>
            <slot class="w-full-h-full pointer-events-auto"/>
          </transition>
        </div>
      </div>

      <div class="w-full py-3 px-2 bg-white bottom-0 flex justify-around space-x-1 z-40 border border-t text-gray-500"
           style="box-shadow: 0px 16px 40px rgba(0, 37, 80, 0.2);">
        <Link @click="closeModals" href="/bodies/1/edit" :only="['']"
              :class="{ 'text-indigo-600':  $page.url.startsWith('/bodies') }">
          <div class="text-sm flex justify-center">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              <div class="mt-0.5 font-semibold">Body</div>
            </div>
          </div>
        </Link>
        <Link @click="closeModals" href="/bodydiff/1" :only="['']"
              :class="{ 'text-indigo-600':  $page.url.startsWith('/bodydiff') }">
          <div class="text-sm flex justify-center">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <div class="mt-0.5 font-semibold">Schedule</div>
            </div>
          </div>
        </Link>
      </div>

    </div>
  </div>
</template>

<script>
import * as THREE from 'three';
import {OrbitControls} from '../../../node_modules/three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from "three/examples/jsm/loaders/GLTFLoader";
import {EffectComposer} from 'three/examples/jsm/postprocessing/EffectComposer.js';
import {RenderPass} from 'three/examples/jsm/postprocessing/RenderPass.js';
import {UnrealBloomPass} from 'three/examples/jsm/postprocessing/UnrealBloomPass.js';
import {Link} from '@inertiajs/inertia-vue3'

import {GUI} from 'dat.gui'

const params = {
  exposure: 0.9,
  bloomStrength: 1,
  bloomThreshold: 0.5,
  bloomRadius: 1
};
let composer;

import body from '../Mixins/body'

let container, camera, renderer, controls;
let sceneL, sceneR;

let sliderPos = window.innerWidth / 2;

let humanL, humanR;

export default {
  props: ['body', 'newBody'],
  components: {Link},
  mixins: [body],
  data() {
    return {
      modal: false,
    }
  },
  mounted() {
    this.init();
    this.animate();
  },
  watch: {
    newBody: {
      handler(newValue, oldValue) {
        this.getBodyMorphTargetInfluences(humanR, this.newBody);
      },
      deep: true
    },
    body: {
      handler(newValue, oldValue) {
        console.log('watch Body', this.body);
        this.getBodyMorphTargetInfluences(humanL, this.body);

      },
      deep: true
    }
  },
  methods: {
    closeModals() {
      console.log('cloeModals');
      this.emitter.emit('cloeModals', true);
    },
    init() {
      container = document.querySelector('.container');

      sceneL = new THREE.Scene();
      // sceneL.background = new THREE.Color(0x4C4C58);
      sceneL.background = null;

      sceneR = new THREE.Scene();
      // sceneR.background = new THREE.Color(0x4C4C58);
      sceneR.background = null;

      camera = new THREE.PerspectiveCamera(35, window.innerWidth / window.innerHeight, 0.1, 100);
      camera.position.z = 6;

      console.log('camera', camera);
      console.log('container', container);

      controls = new OrbitControls(camera, container);

      const light = new THREE.HemisphereLight(0xffffff, 0x444444, 1);
      light.position.set(-2, 2, 2);
      sceneL.add(light.clone());
      sceneR.add(light.clone());

      this.initMeshes();
      this.initSlider();

      renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
      renderer.setClearColor(0xffffff, 0);

      renderer.setPixelRatio(window.devicePixelRatio);
      renderer.setSize(window.innerWidth, window.innerHeight);
      renderer.setScissorTest(true);
      // renderer.setAnimationLoop(this.render);
      container.appendChild(renderer.domElement);

      const renderSceneR = new RenderPass(sceneR, camera);
      const renderSceneL = new RenderPass(sceneL, camera);

      const bloomPass = new UnrealBloomPass(new THREE.Vector2(window.innerWidth, window.innerHeight), 1.5, 0.4, 0.85);
      bloomPass.threshold = params.bloomThreshold;
      bloomPass.strength = params.bloomStrength;
      bloomPass.radius = params.bloomRadius;

      // composer = new EffectComposer(renderer);
      // composer.addPass(renderSceneR);
      // composer.addPass(bloomPass);
      // renderer.toneMappingExposure = Math.pow(params.exposure, 4.0);


      window.addEventListener('resize', this.onWindowResize);

      // sceneL.visible = false;  //Visible
      // sliderPos = 0;

      // const gui = new GUI();
      //
      // gui.add( params, 'exposure', 0.1, 2 ).onChange( function ( value ) {
      //
      //   renderer.toneMappingExposure = Math.pow( value, 4.0 );
      //
      // } );
      //
      // gui.add( params, 'bloomThreshold', 0.0, 1.0 ).onChange( function ( value ) {
      //
      //   bloomPass.threshold = Number( value );
      //
      // } );
      //
      // gui.add( params, 'bloomStrength', 0.0, 3.0 ).onChange( function ( value ) {
      //
      //   bloomPass.strength = Number( value );
      //
      // } );
      //
      // gui.add( params, 'bloomRadius', 0.0, 1.0 ).step( 0.01 ).onChange( function ( value ) {
      //
      //   bloomPass.radius = Number( value );
      //
      // } );

    },

    initMeshes() {

      const geometry = new THREE.IcosahedronGeometry(1, 3);

      let textureLoader = new THREE.TextureLoader();
      const matcapTexture = textureLoader.load("../../../images/metcap-texture2.png");
      const textMaterial = new THREE.MeshMatcapMaterial();
      textMaterial.morphTargets = true;
      textMaterial.morphNormals = true;
      textMaterial.matcap = matcapTexture;


      // model
      const loader = new GLTFLoader();
      // //
      // loader.load('../../../models/morph-t-pose.glb', (gltf) => {
      //   const meshL = gltf.scene;
      //   meshL.scale.set(0.02, 0.02, 0.02);
      //   sceneL.add(meshL);
      //   meshL.castShadow = false;
      //   meshL.position.set(0, -2, 0);
      //   let humanL = meshL.getObjectByName('Human').getObjectByName('human');
      //   humanL.material = textMaterial;
      //
      //
      //   this.getBodyMorphTargetInfluences(humanL, this.body);
      //
      // }, undefined, function (e) {
      //   console.error(e);
      // });

      loader.load('../../../models/morph-t-pose.glb', (gltf) => {
        const meshL2 = gltf.scene;
        sceneL.add(meshL2);
        meshL2.scale.set(0.02, 0.02, 0.02);
        meshL2.castShadow = false;
        meshL2.position.set(0, -2, 0);
        humanL = meshL2.getObjectByName('Human').getObjectByName('human');
        let body = this.body;
        // body.body_fat_percentage = 30;
        console.log('humanL2.material', humanL.material);
        humanL.material = textMaterial;

        // humanL2.material.color.b = 2;
        // humanL2.material = textMaterial;
        // let m1 = new THREE.MeshBasicMaterial({color: 0xFF0000});         // red
        //
        // m1.morphTargets = true;
        // m1.morphNormals = true;
        // humanL2.material = m1;

        // humanL2.material.opacity = 0.15;
        // humanL2.material.transparent = true;
        // humanL2.material.alphaTest = 0;
        // humanL2.material.vertexColors = false;
        // humanL2.material.depthTest = true;
        // humanL2.material.depthWrite = false;


        console.log('humanL2.material', humanL.material);

        this.getBodyMorphTargetInfluences(humanL, body);

      }, undefined, function (e) {
        console.error(e);
      });


      loader.load('../../../models/morph-t-pose.glb', (gltf) => {
        const meshR = gltf.scene;
        meshR.scale.set(0.02, 0.02, 0.02);
        let human = meshR.getObjectByName('Human').getObjectByName('human');
        // human.material = new THREE.MeshBasicMaterial({
        //   color: 0x0095DD,
        //   wireframe: false,
        // });

        human.material = textMaterial;

        sceneR.add(meshR);
        meshR.castShadow = false;
        meshR.position.set(0, -2, 0);
        humanR = meshR.getObjectByName('Human').getObjectByName('human');
        this.getBodyMorphTargetInfluences(humanR, this.newBody);

      }, undefined, function (e) {
        console.error(e);
      });

    },

    initSlider() {

      const slider = document.querySelector('.slider');
      const sliderWall = document.querySelector('.slider-wall');

      let onPointerDown = () => {
        console.log('onPointerDown');

        if (event.isPrimary === false) return;

        controls.enabled = false;

        window.addEventListener('pointermove', onPointerMove);
        window.addEventListener('pointerup', onPointerUp);

      }

      let onPointerUp = () => {
        console.log('onPointerUp');

        controls.enabled = true;

        window.removeEventListener('pointermove', onPointerMove);
        window.removeEventListener('pointerup', onPointerUp);

      }

      function onPointerMove(e) {

        console.log('onPointerMove', e);
        if (event.isPrimary === false) return;

        let sliderLeft = parseInt(window.getComputedStyle(sliderWall, null).getPropertyValue('left'), 10);

        let newSliderPos = Math.max(0, Math.min(window.innerWidth, e.pageX));


        //TODO: execpt if slider is going left
        // if( (sliderLeft < document.body.clientWidth - 20) && sliderLeft < sliderPos ){

        let sliderIsLeft = !(newSliderPos - 20 > sliderPos - (slider.offsetWidth / 2));
        let sliderInBounds = (sliderLeft < document.body.clientWidth);

        if (sliderInBounds || sliderIsLeft) {
          sliderPos = newSliderPos;
          slider.style.left = sliderPos - (slider.offsetWidth / 2) + "px";
          sliderWall.style.left = sliderPos - (sliderWall.offsetWidth / 2) + "px";

        }

      }

      slider.style.touchAction = 'none'; // disable touch scroll
      slider.addEventListener('pointerdown', onPointerDown);

    },

    onWindowResize() {
      console.log('onWindowResize');

      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();

      renderer.setSize(window.innerWidth, window.innerHeight);

      this.render();

    },

    render() {

      renderer.setScissor(0, 0, sliderPos, window.innerHeight);
      renderer.render(sceneL, camera);

      renderer.setScissor(sliderPos, 0, window.innerWidth, window.innerHeight);
      renderer.render(sceneR, camera);

    },

    animate() {
      // const dt = clock.getDelta();


      // if (this.mixer) this.mixer.update(dt);

      // requestAnimationFrame(this.animate);
      this.render();
      // composer.render();


      requestAnimationFrame(this.animate);

      // const delta = clock.getDelta();

      // mixer.update( delta );

      // stats.update();

      // composer.render();

    }
  }
}
</script>
<style scoped>
.container {
  position: absolute;
  width: 100%;
  height: 100%;
}

.slider {
  position: fixed;
  cursor: ew-resize;

  width: 40px;
  height: 40px;
  background-color: transparent;
  border: 1px solid white;
  opacity: 1;
  border-radius: 50%;

  top: calc(50% - 20px);
  left: calc(50% - 20px);
}

.slider-wall {
  position: fixed;
  cursor: ew-resize;

  height: 100vh;

  left: calc(50% - 1px);
}

.slider-wall-top {
  position: fixed;
  top: 0;
  width: 1px;
  height: calc(50% - 20px);
  background-color: white;
  opacity: 0.3;
}

.slider-wall-bottom {
  position: fixed;

  bottom: 0;
  width: 1px;
  height: calc(50% - 20px);
  background-color: white;
  opacity: 0.3;
}


</style>
