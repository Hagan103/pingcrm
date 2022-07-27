import { createApp, h } from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3'
import mitt from 'mitt'

InertiaProgress.init()
const emitter = mitt()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  title: title => title ? `${title} - Ping CRM` : 'Ping CRM',
  setup({ el, App, props, plugin }) {
      const app = createApp({ render: () => h(App, props) })
      .use(plugin)
        .component("Link", Link)


      app.config.globalProperties.emitter = emitter
      app.mount(el)
  },
})
