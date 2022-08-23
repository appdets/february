<template>
  <div
    v-if="match"
    class="
      flex      
      gap-2
      flex-col
      sm:flex-row
      mb-4
      transition
      duration-150      
    "
    :class="{
      'pb-4 border-b-2 last:border-none border-dashed border-slate-100': $root.divider || false,
      'opacity-40 pointer-events-none': !match(field.not),
      'items-center': this.middle,
      'items-start': !this.middle,
    }"
  >
    <!-- label  -->
    <f-label :field="field"></f-label>

    <!-- label ends  -->

    <!-- field -->

    <div v-if="match(field.show)" class="w-full flex flex-col gap-2 p-0.5">
      <!-- inputs -->

      <div
        v-if="
          [
            'text',
            'email',
            'password',
            'datetime-local',
            'date',
            'number',
            'month',
            'search',
            'tel',
            'time',
            'url',
            'week',
          ].includes(field.type)
        "
        class="w-full flex items-center gap-2"
        :class="[field.disabled ? 'opacity-70' : '', field.class]"
      >
        <!-- <span v-show="field.before" v-html="field.before"></span> -->
        <input
          :type="field.type || 'text'"
          :id="getId"
          :maxlength="field.maxlength || ''"
          :min="field.min || 0"
          :max="field.max || 100"
          :step="field.step || 1"
          :name="getId"
          :pattern="field.pattern || ''"
          class="form-input w-full"
          v-model="$root.fields[field.id]"
          :placeholder="field.placeholder || ''"
          :required="field.required || 0"
          :readonly="field.readonly || 0"
          :disabled="field.disabled || 0"
        />
        <!-- <span v-show="field.after" v-html="field.after"></span> -->
      </div>

      <!-- details -->
      <div
        class="text-xs text-slate-500"
        v-if="field.description"
        v-html="field.description || ''"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    field: {
      type: Object,
      default: {},
    },
    section: {
      type: Object,
      default: {},
    },
    middle: {
      type: Boolean,
      default: false, 
    }
  },
  data() {
    return {
      temp: {},
    };
  },
  computed: {
    isVisible() {
      return true;
    },

    getId() {
      return "february_field_" + this.field.id;
    },
  },
  methods: {
    match() {
      return true;
    },
  },
  mounted() {
    // console.log(this.field);
  },
};
</script>