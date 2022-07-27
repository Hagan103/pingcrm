<template>
  <div
   class="left-0 top-0 absolute z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div  @click="$emit('close-modal')"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed z-10 inset-0 overflow-y-auto pointer-events-none">
      <div class="flex items-center justify-center min-h-full text-center sm:p-0">
        <div
          class="flex flex-col pointer-events-auto w-screen h-screen	left-0 top-0 absolute z-50 bg-white px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all  max-w-lg w-full">
          <div class="relative text-center">
            <div class="absolute">

              <svg
                @click="$emit('close-modal')"
                xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              <slot name="header"></slot>
            </h3>
          </div>
          <div class="flex flex-col flex-grow mt-3">

            <div class="flex flex-col flex-grow mt-2">
              <!-- This example requires Tailwind CSS v2.0+ -->
              <div class="flex flex-col flex-grow justify-between mt-3">
              <slot></slot>
              </div>
            </div>
            <div class="mt-5">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
name: "FullPageModal",



}
</script>

<style scoped>

</style>
