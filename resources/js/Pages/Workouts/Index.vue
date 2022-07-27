<template>
 <div>
   <full-page-modal @close-modal="back">
     <template v-slot:header>
       Create Workout
     </template>
     <template v-slot:footer>
     </template>
     <div class="flex flex-col flex-grow justify-between mt-3">
       <div class="space-y-10">
         <Link href="/runs/create" class="block w-full shadow bg-white py-4 text-3xl font-bold text-center rounded">
           Run
         </Link>
       </div>
     </div>
   </full-page-modal>
 </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import BodyLayout from "@/Shared/BodyLayout";
import FullPageModal from "@/Shared/FullPageModal";

export default {
  components: {
    FullPageModal,
    Head,
    Link
  },
  layout: BodyLayout,
  methods: {
    back() {
      window.history.back();
    },
  }
}
</script>
