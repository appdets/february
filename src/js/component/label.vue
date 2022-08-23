<template>
  <div class="sm:w-1/4 w-full flex items-center gap-1" v-if="isVisible">
    <label
      v-show="label"
      :for="getId"
      class="
        font-medium
        text-sm text-slate-700
        cursor-pointer
        flex
        items-center
        gap-2
      "
    >
      <span>{{ label }}</span>
    </label>

    <!-- Tooltip -->
    <f-tooltip v-if="field.hints || field.instruction || field.help" :text="field.hints || field.instruction || field.help"></f-tooltip>
  </div>
</template>

<script>
export default {
  props: {
    field: {
      type: Object,
      default: {},
    },
  },
  computed: {
    getId() {
      return "february_field_" + this.field.id;
    },

    isVisible() {
      return !(
        this.$root.section.full ||
        ["divider", "space"].includes(this.field.type)
      );
    },

    label() {
      return this.field.label;
    },
  },
};
</script>