<template>
  <div
    id="swipe-modal-takumaru-vue-swipe-modal"
    @mousemove="mouseMove"
    @mouseup="mouseUp"
  >
    <transition name="swipe-modal-background" :css="animated">
      <!--        :style="{-->
      <!--          backgroundColor: backgroundColor,-->
      <!--        }"-->
      <!--      @mouseup.prevent="persistent ? null : close()"-->

      <div
        v-if="modelValue"
        class="modal-background pointer-events-none	"
      />
    </transition>
    <transition name="swipe-modal-contents" appear :css="animated">
      <div
        v-if="modelValue"
        ref="modal-contents"
        class="modal-contents flex flex-col"
        :style="styles"
        @touchstart="touchStart"
        @touchmove="touchMove"
        @touchend="touchEnd"
      >
        <div
          v-if="!noTip"
          class="modal-contents-chip-wrapper"
          @mousedown="mouseDown"
        >
          <div class="bg-gray-300  h-1 rounded-full w-14"></div>

          <!--          <div-->
          <!--            class="modal-contents-chip flex justify-center"-->
          <!--            :style="`-->
          <!--              &#45;&#45;tip-color: ${tipColor};-->
          <!--            `"-->
          <!--          />-->

        </div>

<!--        overflow-auto h-screen-->
        <div ref="modal-slot" class="modal-slot py-3  h-full">
          <slot/>
        </div>

      </div>
    </transition>
  </div>
</template>

<script>
export default ({
  name: 'swipe-modal',
  // model: {
  //   prop: 'modelValue',
  //   event: 'update:modelValue',
  // },
  props: {
    // modal
    modelValue: {
      type: Boolean,
      default: false,
    },
    dark: {
      type: Boolean,
      default: false,
    },
    // modal_background
    persistent: {
      type: Boolean,
      default: false,
    },
    backgroundColor: {
      type: String,
      default: '#80808080',
    },
    // modal_contents
    fullscreen: {
      type: Boolean,
      default: false,
    },
    noTip: {
      type: Boolean,
      default: false,
    },
    contentsWidth: {
      type: String,
      default: '100%',
    },
    contentsHeight: {
      type: String,
      default: '30vh',
    },
    borderTopRadius: {
      type: String,
      default: null,
    },
    borderTopLeftRadius: {
      type: String,
      default: '0px',
    },
    borderTopRightRadius: {
      type: String,
      default: '0px',
    },
    contentsColor: {
      type: String,
      default: 'white',
    },
    tipColor: {
      type: String,
      default: '#c8c8c8',
    },
    darkContentsColor: {
      type: String,
      default: '#1E1E1E',
    },
    animated: {
      type: Boolean,
      default: false
    }
  },
  // emits: ['update:modelValue'],
  data() {
    return {
      propsRef: null,
      isMouseDown: false,
      isTouch: false,
      modalQuery: null,
      modalSlot: null,
      modalHeight: 0,
      contentsBottomPosition: '0px',
      moveStartPosition: 0,
      nowMovePosition: 0,
    }
  },
  computed: {
    modal: {
      get: () => this.modelValue,
      set: (value) => context.emit('update:modelValue', value),
    },
    styles() {
      return {
        width: this.contentsWidth,
        borderTopLeftRadius: this.borderTopRadius ? this.borderTopRadius : this.borderTopLeftRadius,
        borderTopRightRadius: this.borderTopRadius ? this.borderTopRadius : this.borderTopRightRadius,
        backgroundColor: this.dark ? this.darkContentsColor : this.contentsColor,
        color: this.dark ? 'white' : 'black',
        /* '--contents-height': propsRef.fullscreen? '100%' : modalHeight > 0 ? modalHeight + 'px' : propsRef.contentsHeight,
      '--contents-bottom-position': contentsBottomPosition ? contentsBottomPosition : '0px', */
      }
    },
    modalValue() {
      return this.modelValue;
    },
  },
  watch: {
    // whenever question changes, this function will run
    modalValue(newModal) {
      if (newModal.valueOf()) {
        this.open()
      }
    }
  },
  created(){
    this.emitter.on('cloeModals', (evt) => {
      this.close()
    })
  },
  methods: {
    init() {
      this.isMouseDown = false
      this.isTouch = false
      this.modalQuery = null
      this.modalHeight = 0
      this.contentsBottomPosition = '0px'
      this.moveStartPosition = 0
      this.nowMovePosition = 0
      document.documentElement.style.setProperty('--contents-height', this.fullscreen ? '100%' : this.modalHeight > 0 ? this.modalHeight + 'px' : this.contentsHeight)
      document.documentElement.style.setProperty('--contents-bottom-position', this.contentsBottomPosition ? this.contentsBottomPosition : '0px')
    },

    open() {
      this.init()
      document.documentElement.style.overflowY = 'hidden'
    },
    close() {
      this.isMouseDown = false
      this.isTouch = false
      document.documentElement.style.overflowY = 'auto'
      this.$emit('update:modelValue', false)
    },
    mouseDown(payload) {
      this.modalQuery = document.querySelector('.modal-contents')
      this.modalHeight = this.modalQuery.getBoundingClientRect().height
      this.moveStartPosition = payload.pageY
      this.isMouseDown = true
    },
    mouseMove(payload) {
      if (this.isMouseDown) {
        this.nowMovePosition = payload.pageY
        this.contentsBottomPosition = (
          this.moveStartPosition - this.nowMovePosition <= 0
            ? this.moveStartPosition - this.nowMovePosition
            : 0
        ) + 'px'
      }
      document.documentElement.style.setProperty('--contents-bottom-position', this.contentsBottomPosition ? this.contentsBottomPosition : '0px')
    },
    mouseUp() {
      this.isMouseDown = false
      if (-1 * (this.moveStartPosition - this.nowMovePosition) > this.modalHeight * (1 / 8)) {
        this.close()
      } else {
        this.contentsBottomPosition = 0 + 'px'
      }
    },
    touchStart(payload) {
      this.modalQuery = document.querySelector('.modal-contents');
      this.modalSlot = document.querySelector('.modal-slot');
      this.modalHeight = this.modalQuery.getBoundingClientRect().height
      if (this.modalQuery.scrollTop <= 0 && this.modalSlot.scrollTop <= 0) {
        this.moveStartPosition = payload.touches[0].pageY
        this.isTouch = true
      }
    },
    touchMove(payload) {
      if (this.isTouch) {
        this.nowMovePosition = payload.touches[0].pageY
        if (this.moveStartPosition - this.nowMovePosition <= 0) {
          this.contentsBottomPosition = this.moveStartPosition - this.nowMovePosition + 'px'
        } else {
          this.contentsBottomPosition = 0 + 'px'
        }
        this.contentsBottomPosition = (this.moveStartPosition - this.nowMovePosition <= 0 ? this.moveStartPosition - this.nowMovePosition : 0) + 'px'
      }
      document.documentElement.style.setProperty('--contents-bottom-position', this.contentsBottomPosition ? this.contentsBottomPosition : '0px')
    },
    touchEnd() {
      this.isTouch = false
      if (
        -1 * (this.moveStartPosition - this.nowMovePosition) >
        this.modalHeight * (1 / 8)
      ) {
        this.close()
      } else {
        this.contentsBottomPosition = 0 + 'px';
      }
    },
  },
})
</script>

<style lang="scss">
:root {
  --contents-height: 30vh;
  --contents-bottom-position: 0%;
}

#swipe-modal-takumaru-vue-swipe-modal {
  //position: fixed;
  scrollbar-width: none;
  z-index: 15;

  .modal-background {
    position: fixed;
    z-index: 11;
    width: 100vw;
    height: 100vh;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .modal-slot {
    overflow-y: scroll;
    -ms-overflow-style: none;
    scrollbar-width: none;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;

    &::-webkit-scrollbar {
      width: 0px;
    }
  }

    .modal-contents {
    position: absolute;
    //position: fixed;
    z-index: 12;
    min-height: var(--contents-height);
    max-height: 100%;
    //max-height: 100vh;
    bottom: var(--contents-bottom-position);
    left: 50%;
    transform: translateX(-50%) translateY(0%);
    //overflow-y: scroll;
    -ms-overflow-style: none;
    scrollbar-width: none;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    //filter: drop-shadow(0px 16px 40px rgba(0, 37, 80, 0.2));
      box-shadow: 0px 16px 40px rgba(0, 37, 80, 0.2);
    &::-webkit-scrollbar {
      width: 0px;
    }

    &-chip-wrapper {
      z-index: 12;
      display: flex;
      justify-items: center;
      align-items: center;
      justify-content: center;
      align-content: center;
      position: relative;
      top: 0px;
      height: 4px;
      width: 100%;
      padding-top: 8px;
      padding-bottom: 8px;
      cursor: s-resize;
    }

    &-chip {
      --tip-color: #c8c8c8;
      width: 40px;
      height: 100%;
      border-radius: 4px;
      background-color: var(--tip-color);
    }
  }

  .swipe-modal-background {
    &-enter {
      & {
        opacity: 0;
      }

      &-from {
        opacity: 0;
      }

      &-active {
        transition: all 0.2s ease-out;
      }

      &-to {
        opacity: 1;
      }
    }

    &-leave {
      & {
        opacity: 1;
      }

      &-from {
        opacity: 1;
      }

      &-active {
        transition: all 0.2s ease-out;
      }

      &-to {
        opacity: 0;
      }
    }
  }

  .swipe-modal-contents {
    &-enter {
      & {
        bottom: calc(-1 * var(--contents-height)) !important;
      }

      &-from {
        bottom: calc(-1 * var(--contents-height)) !important;
      }

      &-active {
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
      }

      &-to {
        bottom: var(--contents-bottom-position) !important;
      }
    }

    &-leave {
      & {
        bottom: var(--contents-bottom-position) !important;
      }

      &-from {
        bottom: var(--contents-bottom-position) !important;
      }

      &-active {
        transition: all 0.25s cubic-bezier(.25, .8, .25, 1);
      }

      &-to {
        bottom: calc(-1 * var(--contents-height)) !important;
      }
    }
  }
}
</style>
