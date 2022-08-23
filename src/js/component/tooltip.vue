<template>
  <div
    class="february-tooltip"
    @click.prevent="show()"
    @mouseover="show()"
    @mouseout="hide()"
  >
    <i
      class="february-tooltip-icon dashicons dashicons-info"
      :class="mouse || over ? 'text-slate-700' : 'text-slate-400'"
    ></i>
    <div
      v-show="over || mouse"
      class="february-tooltip-content"
      v-html="text"
    ></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      mouse: 0,
      over: 0,
      timer: null,
    };
  },
  props: {
    text: {
      type: String,
      default: "",
    },
  },
  methods: {
    show() {
      this.over = 1;
      this.timer = setTimeout(() => {
        this.mouse = 1;
      }, 500);
    },
    hide() {
      this.over = 0;
      this.mouse = 0;
      clearTimeout(this.timer);
    },
  },
};
</script>