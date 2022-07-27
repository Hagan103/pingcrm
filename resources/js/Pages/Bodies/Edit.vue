<template>
  <div>
    <swipe-modal
      :animated="true"
      v-model="modal"
      contents-height=""
      border-top-radius="16px"
    >
      <div class="px-4 space-y-8 divide-y divide-gray-200">
        <div class="space-y-8 divide-y divide-gray-200">
          <div class="">
            <div>
<!--              <h3 class="text-lg leading-6 font-medium text-gray-900">Body</h3>-->
            </div>
            <div class="mt-6 grid grid-cols-2 gap-y-6 gap-x-4">
              <div>
                <label for="weight" class="block text-sm font-medium text-gray-700"> Weight </label>
                <div class="mt-1">
                  <input @input="update" v-model="form.weight" type="number" name="weight" id="weight" autocomplete="weight" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>

              <div>
                <label for="body-fat-percentage" class="block text-sm font-medium text-gray-700"> Body Fat Percentage </label>
                <div class="mt-1">
                  <input @input="update" v-model="form['body_fat_percentage']"  type="number" name="body-fat-percentage" id="body-fat-percentage" autocomplete="body-fat-percentage" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>

              <div>
                <label for="height" class="block text-sm font-medium text-gray-700"> Height </label>
                <div class="mt-1">
                  <input @input="update" v-model="form.height" type="number" id="height" name="height" autocomplete="height" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>

              <div>
                <label for="age" class="block text-sm font-medium text-gray-700"> Age </label>
                <div class="mt-1">
                  <input @input="update" v-model="form.age" type="number" id="age" name="age" autocomplete="age" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>


              <fieldset class="col-span-2">
                <legend class="contents text-base font-medium text-gray-900">Sex</legend>
<!--                <p class="text-sm text-gray-500">These are delivered via SMS to your mobile phone.</p>-->
                <div class="mt-1 space-y-2 space-x-2 flex">
                  <div class="flex items-center">
                    <input id="male" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="male" class="ml-3 block text-sm font-medium text-gray-700"> Male </label>
                  </div>
                  <div class="flex items-center">
                    <input id="female" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="female" class="ml-3 block text-sm font-medium text-gray-700"> Female </label>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>

<!--        <div class="pt-5">-->
<!--          <div class="flex justify-end">-->
<!--            <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>-->
<!--            <button @click="update" type="button" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>-->
<!--          </div>-->
<!--        </div>-->
      </div>
    </swipe-modal>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import BodyLayout from "@/Shared/BodyLayout";
import SwipeModal from "../../Shared/SwipeModal";
import axios from "axios";

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    SwipeModal
  },
  layout: BodyLayout,
  props: {
    body: Object,
  },
  remember: 'form',
  data() {
    return {
      modal: false,
      form: {
        'weight': this.body.weight,
        'height': this.body.height,
        'body_fat_percentage': this.body.body_fat_percentage,
        'age': this.body.age,
        'sex': this.body.sex,
      },
    }
  },
  mounted() {
    this.modal = true;
  },
  methods: {
    update() {
      console.log('update');
      // this.form.put(`/bodies/${this.Body.id}`)
        axios.put('/bodies/'+this.body.id, this.form, {
          headers: {
            'Content-Type': 'application/json',
          },
        })
          .then(res => {
            this.$inertia.reload({ only: ['body'] });
          });
      },
    // destroy() {
    //   if (confirm('Are you sure you want to delete this organization?')) {
    //     this.$inertia.delete(`/bodies/${this.Body.id}`)
    //   }
    // },
    // restore() {
    //   if (confirm('Are you sure you want to restore this organization?')) {
    //     this.$inertia.put(`/bodies/${this.Body.id}/restore`)
    //   }
    // },
  },
}
</script>
