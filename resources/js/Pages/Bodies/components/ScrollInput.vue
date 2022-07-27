<template>

  <div class="relative">

      <div>
        <div :ref="'carousel-' +  name" :class="'carousel'">
          <div v-for="index in list"
               :key="index"
               class="w-16 flex items-center justify-center h-40 mx-2 font-semibold text-gray-400">
            <div
              class="weight-value inline-block transition-all ease-in-out duration-700 select-none text-lg mb-10"
              :class="{'scale-300 transform text-black font-bold pb-2':(flcktyValue == index) && !flickityIsDragging}"
            >
              {{ index }}
            </div>

            <div class="absolute flex items-end bottom-0 justify-between w-full">
              <div class=" w-0.5 select-none  h-6 bg-gray-300">
              </div>
              <div class=" w-0.5 select-none  h-6 bg-gray-300">
              </div>
              <div class=" w-0.5 select-none  h-10 bg-gray-300">
              </div>
              <div class=" w-0.5 select-none  h-6 bg-gray-300">
              </div>
              <div class=" w-0.5 select-none  h-6 bg-gray-300">
              </div>
            </div>

          </div>
        </div>

        <div class="absolute  bottom-0 w-full  pointer-events-none">
          <div class="flex justify-center pointer-events-none h-8 font-semibold text-black">
            <span v-if="unit">kg</span>
          </div>
          <div class="flex justify-center">
            <div class="w-0.5  bottom-0  select-none text-6xl h-11 bg-black">
            </div>
          </div>

        </div>
      </div>
  </div>
</template>

<script>
import Flickity from "flickity";

export default {
  name: "ScrollInput",
  data() {
    return {
      flickityOptions: {
        dragThreshold: 50,
        initialIndex: this.value - this.min,
        prevNextButtons: false,
        pageDots: false,
        wrapAround: false,
        hash: true,
        // percentPosition: false,
        // freeScroll: true,
        // freeScrollFriction: 0.08,

        // selectedAttraction: 0.01,
        // friction: 0.15
        // draggable: false

      },
      stageDragging: false,
      flkty: null,
      list: [],
      flickityIsAnimating: false,
      flickityIsDragging: false,
    }
  },
  props: {
    label: {
      type: String,
      required: false,
    },
    value: {
      type: String,
      required: true,
    },
    min: {
      type: Number,
      required: true,
    },
    max: {
      type: Number,
      required: true,
    },
    unit: {
      type: String,
      required: false,
    },

  },
  /* Can add validation here
  watch: {
    value: {
      handler(newValue, oldValue) {

      },
    },
  }, */
  created() {
    for (var i = this.min; i <= this.max; i++) {
      this.list.push(i);
    }
    return this.list;
  },
  mounted() {
    this.flkty = new Flickity(this.$refs['carousel-' + this.name], this.flickityOptions);

    this.flkty.on("dragStart", (drag) => {
      this.stageDragging = true;
      console.log("stageDragging: " + this.stageDragging);
      this.flickityIsDragging = true;
    });

    this.flkty.on("dragEnd", () => {
      this.flkty.next();
      this.flkty.previous();
      this.stageDragging = false;
      console.log("stageDragging: " + this.stageDragging);

      this.flickityIsDragging = false;
    });

    this.flkty.on("settle", (index) => {
      console.log("Slide settle " + index);
      this.flickityIsAnimating = false;
    });

    this.flkty.on("change", (index) => {

      this.onChange()
    });

    this.$nextTick(() => {
      window.dispatchEvent(new Event('resize'));
    });


    var carousel = document.querySelector(".carousel");
    var flickity_1_is_animating = false;

    // detect mousewheel event within carousel element
    carousel.onwheel = (e) => {
      this.flickityHandleWheelEvent(e, this.flkty);
    }


  },
  computed: {
    flcktyValue() {
      if (this.flkty) {
        return this.list[this.flkty.selectedIndex];
      }
    },
    name() {
      if (this.label) {
        return this.label.toLowerCase();

      }
      return '';
    },
  },
  methods: {

    flickityHandleWheelEvent(e, flickity_instance) {
      // do not trigger a slide change if another is being animated
      // pick the larger of the two delta magnitudes (x or y) to determine nav direction
      var direction = (Math.abs(e.deltaX) > Math.abs(e.deltaY)) ? e.deltaX : e.deltaY;


      if (direction > 0) {
        // next slide
        flickity_instance.next();
      } else {
        // prev slide
        flickity_instance.previous();
      }
    },
    // onInput(event) {
    //   // Can add validation here
    //   this.$emit('input', event.target.value);
    // },
    onChange(event) { // Supports .lazy
      // Can add validation here
      console.log('change')
      // this.modelValue = this.flcktyValue;
      console.log(' this.flcktyValue', this.flcktyValue);
      this.$emit('input', this.flcktyValue);
    },
  },
}
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

.fade-up-enter-active,
.fade-up-leave-active {
  transition: opacity 2s ease;
}

.fade-up-enter-from {
  opacity: 0;
}

.fade-up-leave-to {
  opacity: 0;
}




/* external css: flickity.css */
.weight-value {
  font-smoothing: antialiased;
  -webkit-font-smoothing: antialiased;
  -webkit-backface-visibility: hidden;
  /*-webkit-transform: translateZ(0px);*/

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
