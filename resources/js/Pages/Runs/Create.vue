<template>
  <div>
    <full-page-modal @close-modal="back">
      <template v-slot:header>
        Create Run
      </template>
      <template v-slot:footer>
      </template>
      <div class="">
        <form @submit.prevent="store">
          <div class="flex flex-wrap">
            <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
            <text-input v-model="form.distance" :error="form.errors.distance" class="pb-8 pr-6 w-full lg:w-1/2" label="Distance (meters)" />
            <text-input v-model="form.duration" :error="form.errors.duration" class="pb-8 pr-6 w-full lg:w-1/2" label="Duration (minutes)" />
          </div>
          <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
            <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Run</loading-button>
          </div>
        </form>
      </div>
    </full-page-modal>
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import BodyLayout from "@/Shared/BodyLayout";
import FullPageModal from "@/Shared/FullPageModal";
import LoadingButton from "@/Shared/LoadingButton";
import SelectInput from "@/Shared/SelectInput";
import TextInput from "@/Shared/TextInput";
import Layout from "@/Shared/Layout";

export default {

  layout: BodyLayout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        distance: null,
        duration: null,
      }),
    }
  },
  components: {
    Head,
    FullPageModal,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  methods: {
    store() {
      this.form.post('/runs')
    },
    back() {
      window.history.back();
    },
  }
}
</script>
