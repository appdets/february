import { createApp } from "vue";
import App from "./App.vue";

/**
 * Create the app.
 */
const FebruaryApp = createApp(App);

/**
 * Component registration.
 */

import Field from "./component/field.vue";
FebruaryApp.component("f-field", Field);

import Label from "./component/label.vue";
FebruaryApp.component("f-label", Label);

import Tooltip from "./component/tooltip.vue";
FebruaryApp.component("f-tooltip", Tooltip);

/**
 * Event emitter for the app.
 */
import mitt from "mitt";
const emitter = mitt();
FebruaryApp.config.globalProperties.emitter = emitter;

/**
 * Mount the app.
 */

window.addEventListener("DOMContentLoaded", () => {
  window.february = FebruaryApp.mount("[data-february]");
});