<template>
  <div    
    v-show="0 && isVisible"
    class="
      flex
      items-start
      gap-2
      flex-col
      sm:flex-row
      mb-4
      transition
      duration-150
    "
    :class="{
      'pb-4 border-b-2 last:border-none border-dashed border-slate-100':
        data.divider || 0,
      'opacity-40 pointer-events-none': conditional_fade(field.not),
    }"
  >
    <!-- label  -->
    <div
      class="sm:w-1/4 w-full flex items-center gap-1"
      v-if="
        !section.full &&
        !['divider', 'space'].includes(field.type) &&
        conditional_hide(field.show)
      "
    >
      <label
        v-show="field.label"
        :for="'february_field_' + field.id"
        class="
          font-medium
          text-sm text-slate-700
          cursor-pointer
          flex
          items-center
          gap-2
        "
      >
        <span>{{ field.label }}</span>

        <!-- <div v-if="field.required"
                      class="february-tooltip"
                      v-data="{ over: 0, mouse: 0, timer: null }"
                      @click.prevent="
                        clearTimeout(timer);
                        mouse = !mouse;
                      "
                      @click.away="
                        clearTimeout(timer);
                        mouse = 0;
                        over = 0;
                      "
                      @mouseover="
                        clearTimeout(timer);
                        timer = setTimeout(() => {
                          over = 1;
                        }, 10);
                      "
                      @mouseleave="
                        clearTimeout(timer);
                        timer = setTimeout(() => {
                          over = 0;
                        }, 10);
                      "
                    >
                      <span
                        :class="mouse || over ? 'text-red-700' : 'text-red-400'"
                        >*</span
                      >
                      <div
                        v-show="over || mouse"
                        class="february-tooltip-content min-w-0"
                      >
                        Required!
                      </div>
                    </div>  -->
      </label>

      <!-- Tooltip starts-->
      <!-- <div
                v-if="field.hints || field.instruction || field.tooltip"
                class="february-tooltip"
                v-data="{ over: 0, mouse: 0, timer: null }"
                @click.prevent="
                  clearTimeout(timer);
                  mouse = !mouse;
                " 
                @mouseover="
                  clearTimeout(timer);
                  timer = setTimeout(() => {
                    over = 1;
                  }, 700);
                "
                @mouseleave="
                  clearTimeout(timer);
                  timer = setTimeout(() => {
                    over = 0;
                  }, 700);
                "
              >
                <i
                  class="february-tooltip-icon dashicons dashicons-info"
                  :class="mouse || over ? 'text-slate-700' : 'text-slate-400'"
                ></i>
                <div
                  v-show="over || mouse"
                  class="february-tooltip-content"
                  v-html="field.hints || field.instruction || field.tooltip"
                ></div>
              </div> -->
      <!-- Tooltip ends -->
    </div>

    <!-- label ends  -->

    <!-- field -->

    <div
      v-if="false && (conditional_hide(field.show) || 1)"
      v-transition
      class="w-full flex flex-col gap-2 p-0.5"
    >
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
        <span v-show="field.before" v-html="field.before"></span>
        <input
          :type="field.type"
          :id="'february_field_' + field.id"
          :maxlength="field.maxlength"
          :min="field.min"
          :max="field.max"
          :step="field.step"
          :name="'february_field_' + field.id"
          :pattern="field.pattern"
          class="form-input w-full"
          v-model="fields[field.id]"
          :placeholder="field.placeholder || ''"
          :required="field.required || false"
          :readonly="field.readonly || false"
          :disabled="field.disabled || false"
        />
        <span v-show="field.after" v-html="field.after"></span>
      </div>

      <!-- hidden field  -->
      <template v-if="['hidden'].includes(field.type)">
        <input
          type="hidden"
          :name="'february_field_' + field.id"
          :id="'february_field_' + field.id"
          v-model="fields[field.id]"
        />
      </template>

      <!-- select -->
      <template v-if="['select'].includes(field.type)">
        <!-- select -->
        <div
          class="flex flex-col items-center relative w-52"
          :class="[field.disabled ? 'opacity-70' : '', field.class]"
        >
          <div class="w-full">
            <template v-if="field.selectDropdown">
              <div
                class="fixed top-0 left-0 w-full h-full z-0"
                @click.prevent="field.selectDropdown = false"
              ></div>
            </template>
            <template v-if="field.selectDropdown">
              <div class="bg-white p-1 flex border border-gray-200 rounded">
                <input
                  v-model="field.search"
                  class="
                    p-1
                    pv-2
                    appearance-none
                    outline-none
                    w-full
                    text-gray-800 text-sm
                    z-50
                  "
                  :placeholder="field.placeholder || ''"
                  @click.prevent="field.selectDropdown = true"
                />

                <div
                  class="flex items-center text-slate-500 pv-1 cursor-pointer"
                  @click="field.selectDropdown = !field.selectDropdown"
                >
                  <span class="dashicons dashicons-arrow-down-alt2"></span>
                </div>
              </div>
            </template>
            <template v-if="!field.selectDropdown">
              <div class="bg-white py-1 flex border border-gray-200 rounded">
                <button
                  class="
                    py-1
                    m-0
                    pv-2
                    z-0
                    outline-none
                    w-full
                    text-gray-800 text-sm text-left
                  "
                  @click="field.selectDropdown = !field.selectDropdown"
                >
                  <template
                    v-if="
                      field.options &&
                      build_options(field.options).find(
                        (opt) => opt.value == fields[field.id]
                      ) &&
                      build_options(field.options).find(
                        (opt) => opt.value == fields[field.id]
                      ).icon
                    "
                  >
                    <span
                      :class="
                        build_options(field.options).find(
                          (opt) => opt.value == fields[field.id]
                        ).icon
                      "
                    ></span>
                  </template>
                  <span
                    v-text="
                      field.options &&
                      build_options(field.options).find(
                        (opt) => opt.value == fields[field.id]
                      )
                        ? build_options(field.options).find(
                            (opt) => opt.value == fields[field.id]
                          ).label || field.placeholder
                        : field.placeholder
                    "
                  ></span>
                </button>

                <div
                  class="flex items-center text-slate-500 pv-1 cursor-pointer"
                  @click="field.selectDropdown = !field.selectDropdown"
                >
                  <span class="dashicons dashicons-arrow-down-alt2"></span>
                </div>
              </div>
            </template>
          </div>

          <template v-if="field.selectDropdown">
            <div
              class="
                absolute
                shadow-lg
                top-full
                z-50
                w-full
                lef-0
                rounded
                mav-h-52
                scrollbar-thin scrollbar-thumb-teal-700 scrollbar-track-gray-100
                overflow-y-auto
                text-sm
              "
            >
              <div class="flex flex-col w-full">
                <div
                  v-for="option in build_options(field.options)"
                  :key="option.value"
                  v-show="
                    !field.search
                      ? true
                      : option.label
                          .toLowerCase()
                          .includes(field.search.toLowerCase()) ||
                        option.value
                          .toLowerCase()
                          .includes(field.search.toLowerCase())
                  "
                  @click.prevent="
                    fields[field.id] = option.value;
                    field.selectDropdown = false;
                    field.search = '';
                  "
                  class="cursor-pointer w-full mb-0 border-t border-slate-100"
                >
                  <div
                    v-show="field.search ? false : true"
                    class="
                      flex
                      w-full
                      items-center
                      p-2
                      pl-2
                      border-transparent border-l-4
                      relative
                      hover:bg-slate-100
                    "
                    :class="[
                      option.value === fields[field.id]
                        ? 'border-teal-600 bg-slate-100'
                        : 'bg-white',
                    ]"
                  >
                    <span v-show="option.icon" :class="option.icon"></span>
                    <div class="w-full items-center flex" v-show="option.label">
                      <div
                        class="mv-2 leading-6"
                        v-html="option.label || ''"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </template>

      <!-- slider range -->
      <template v-if="['range'].includes(field.type)">
        <div
          class="flex items-center gap-2"
          :class="[field.disabled ? 'opacity-70' : '', field.class]"
        >
          <span class="text-base text-slate-600 flex items-center min-w-24">
            <span v-show="field.before" v-html="field.before"></span>
            <input
              type="number"
              v-model="fields[field.id]"
              :id="'february_field_' + field.id"
              :name="'february_field_' + field.id"
              class="form-input w-14"
            />
            <span v-show="field.after" v-html="field.after"></span>
          </span>
          <div class="w-full">
            <input
              class="
                rounded-lg
                overflow-hidden
                appearance-none
                bg-slate-200
                h-3
                w-full
              "
              type="range"
              :min="field.min"
              :max="field.max"
              :step="field.step"
              v-model="fields[field.id]"
            />
          </div>
        </div>
      </template>

      <!-- checkbox -->
      <template v-if="['checkbox'].includes(field.type)">
        <div>
          <label class="inline-flex items-center gap-1.5 rounded-md w-auto">
            <input
              v-model="fields[field.id]"
              :name="'february_field_' + field.id"
              type="checkbox"
              class="hidden peer"
            />
            <span
              class="
                w-4
                h-4
                rounded-sm
                bg-slate-200
                peer-checked:bg-teal-600
                text-transparent
                peer-checked:text-white
                transition
                duration-150
                flex
                items-center
                justify-center
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current w-2.5"
                viewBox="0 0 24 24"
              >
                <path
                  d="M0 11.386l1.17-1.206c1.951.522 5.313 1.731 8.33 3.597 3.175-4.177 9.582-9.398 13.456-11.777l1.044 1.073-14 18.927-10-10.614z"
                />
              </svg>
            </span>
            <span
              v-show="field.label"
              v-text="field.label"
              class="text-sm"
            ></span>
          </label>
        </div>
      </template>

      <!-- multiple checkbox -->
      <template v-if="['multi_checkbox'].includes(field.type)">
        <div
          class="flex gap-3"
          :class="[
            field.inline ? 'flex-row items-center' : 'flex-col',
            field.class,
          ]"
        >
          <template
            v-show="field.options && field.options.length"
            v-for="option in build_options(field.options)"
          >
            <template v-if="option && option.value">
              <label class="flex items-center gap-1.5 rounded-md">
                <input
                  :checked="fields[field.id].includes(option.value)"
                  :name="'february_field_' + field.id + '_' + option.value"
                  type="checkbox"
                  class="hidden peer"
                  @change="
                    fields[field.id].includes(option.value)
                      ? (fields[field.id] = fields[field.id].filter(
                          (item) => item !== option.value
                        ))
                      : fields[field.id].push(option.value)
                  "
                />
                <span
                  class="
                    w-4
                    h-4
                    rounded-sm
                    bg-slate-200
                    peer-checked:bg-teal-600
                    text-transparent
                    peer-checked:text-white
                    transition
                    duration-150
                    flex
                    items-center
                    justify-center
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-current w-2.5"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M0 11.386l1.17-1.206c1.951.522 5.313 1.731 8.33 3.597 3.175-4.177 9.582-9.398 13.456-11.777l1.044 1.073-14 18.927-10-10.614z"
                    />
                  </svg>
                </span>

                <span
                  v-show="option.label"
                  v-text="option.label"
                  class="text-sm"
                ></span>
              </label>
            </template>
          </template>
        </div>
      </template>

      <!-- multiple switch -->
      <template v-if="['multi_switch'].includes(field.type)">
        <div
          class="flex gap-3"
          :class="[
            field.inline ? 'flex-row items-center' : 'flex-col',
            field.class,
          ]"
        >
          <div v-show="field.options && field.options.length">
            <label
              v-for="option in build_options(field.options)"
              :key="option.value"
              class="flex items-center cursor-pointer gap-3"
              :class="[field.disabled ? 'opacity-70' : '', field.class]"
              @click.prevent="
                fields[field.id].includes(option.value)
                  ? (fields[field.id] = fields[field.id].filter(
                      (item) => item !== option.value
                    ))
                  : fields[field.id].push(option.value)
              "
            >
              <div
                :class="{
                  'bg-teal-600': fields[field.id].includes(option.value),
                  'bg-slate-200': !fields[field.id].includes(option.value),
                }"
                class="w-10 h-4 flex items-center rounded-full"
              >
                <div
                  class="
                    bg-white
                    w-5
                    h-5
                    rounded-full
                    shadow-md
                    transform
                    transition
                    duration-150
                    ring-1 ring-slate-100
                  "
                  :class="{
                    'translate-v-5': fields[field.id].includes(option.value),
                  }"
                ></div>
              </div>
              <span class="text-slate-600 text-sm" v-html="option.label"></span>
            </label>
          </div>
        </div>
      </template>

      <!-- radio -->
      <template v-if="['radio'].includes(field.type)">
        <div
          class="flex gap-2"
          :class="[
            field.disabled ? 'opacity-70' : '',
            field.class,
            field.inline ? 'flex-row gap-4' : 'flex-col',
          ]"
          :id="'february_field_' + field.id"
        >
          <div v-if="field.options && field.options.length">
            <label
              v-for="option in build_options(field.options)"
              :key="option.value"
              class="flex items-center gap-1.5 rounded-md"
              @click="fields[field.id] = option.value"
            >
              <input
                :value="option.value"
                :checked="fields[field.id] == option.value"
                :name="'february_field_' + field.id + '_' + option.value"
                type="radio"
                class="hidden peer"
              />
              <span
                class="
                  w-4
                  h-4
                  rounded-full
                  bg-slate-200
                  peer-checked:bg-teal-600
                  transition
                  duration-150
                  flex
                  items-center
                  justify-center
                "
              >
                <span class="bg-white w-2 h-2 block rounded-full"></span>
              </span>
              <span
                v-show="option.label"
                v-text="option.label"
                class="text-sm"
              ></span>
            </label>
          </div>
        </div>
      </template>

      <!-- switch -->
      <template v-if="['switch'].includes(field.type)">
        <div
          class="flex items-center cursor-pointer gap-3"
          :class="[field.disabled ? 'opacity-70' : '', field.class]"
          @click="fields[field.id] = !fields[field.id]"
        >
          <div
            :class="{
              'bg-teal-600': fields[field.id],
              'bg-slate-200': !fields[field.id],
            }"
            class="w-10 h-4 flex items-center rounded-full"
          >
            <div
              class="
                bg-white
                w-5
                h-5
                rounded-full
                shadow-md
                transform
                transition
                duration-150
                ring-1 ring-slate-100
              "
              :class="{ 'translate-v-5': fields[field.id] }"
            ></div>
          </div>
          <span class="text-slate-600 text-sm" v-html="field.message"></span>
        </div>
      </template>

      <!-- textarea -->
      <template v-if="['textarea'].includes(field.type)">
        <textarea
          :placeholder="field.placeholder"
          :rows="field.rows || 2"
          :required="field.required"
          :class="[field.disabled ? 'opacity-70' : '', field.class]"
          :readonly="field.readonly || false"
          :disabled="field.disabled || false"
          v-model="fields[field.id]"
          class="february-editor w-full form-input textarea"
        ></textarea>
      </template>

      <!-- button group / tab  -->
      <template v-if="['tab', 'button_group'].includes(field.type)">
        <div :class="[field.disabled ? 'opacity-70' : '', field.class]">
          <div class="inline-flex shadow-sm rounded-md">
            <template
              v-for="option in build_options(field.options)"
              :key="option.id"
            >
              <button
                v-show="option.value"
                type="button"
                :title="option.label"
                class="
                  border border-t border-b
                  last:rounded-r-sm
                  border-r-0
                  last:border-r
                  border-gray-200
                  first:rounded-l-sm
                  pv-2
                  py-1.5
                  flex
                  items-center
                  gap-1
                  justify-center
                "
                :class="[
                  fields[field.id] == option.value
                    ? 'bg-teal-600 text-white'
                    : 'bg-white text-slate-700 hover:bg-gray-100 hover:text-teal-700',
                ]"
                @click.prevent="fields[field.id] = option.value"
              >
                <span
                  v-show="option.icon"
                  class="transform"
                  :class="[option.icon, option.label ? 'scale-90' : '']"
                ></span>
                <span
                  class="text-sm font-medium text-center"
                  v-show="
                    option.label &&
                    option.label != 0 &&
                    field.hide_label !== true
                  "
                  v-text="option.label"
                ></span>
              </button>
            </template>
          </div>
        </div>
      </template>

      <!-- message  -->
      <template v-if="['message'].includes(field.type)">
        <div
          v-show="field.html || field.message || field.text"
          :class="[field.class]"
          class="text-sm text-slate-600 bg-slate-100 p-3 rounded-md"
          v-text="field.html || field.message || field.text"
        ></div>
      </template>

      <!-- nohtml  -->
      <template v-if="['nohtml'].includes(field.type)">
        <div
          v-show="field.html || field.message || field.text || field.nohtml"
          v-text="field.html || field.message || field.text || field.nohtml"
        ></div>
      </template>

      <!-- html  -->
      <template v-if="['html'].includes(field.type)">
        <div
          v-show="field.html || field.message || field.text"
          v-html="field.html || field.message || field.text"
        ></div>
      </template>

      <!-- divider  -->
      <template v-if="['divider'].includes(field.type)">
        <div class="border-b-2 border-dashed border-slate-100 my-2"></div>
      </template>

      <!-- space  -->
      <template v-if="['space'].includes(field.type)">
        <div class="my-2"></div>
      </template>

      <!-- image -->
      <template v-if="['image'].includes(field.type)">
        <div
          class="w-full flex items-center gap-2"
          :class="[field.disabled ? 'opacity-70' : '', field.class]"
        >
          <!-- multiple   -->
          <div v-if="fields[field.id] && field.multiple == true">
            <div
              v-for="(attachment, index) in fields[field.id]"
              :key="attachment.id"
              class="
                w-16
                h-16
                border border-slate-100
                shadow-sm
                rounded-md
                relative
                p-2
              "
            >
              <img
                v-show="attachment"
                v-transition
                :src="attachment.url"
                class="w-full"
              />
              <div
                class="
                  absolute
                  top-0
                  left-0
                  w-full
                  h-full
                  overflow-hidden
                  flex
                  items-center
                  justify-center
                "
              >
                <button
                  @click.prevent="
                    fields[field.id] = fields[field.id].filter(
                      (attachIndex) => attachIndex != index
                    )
                  "
                  class="
                    w-6
                    h-6
                    bg-red-400
                    opacity-0
                    hover:opacity-100
                    rounded-md
                    flex
                    items-center
                    justify-center
                    text-xs text-gray-600
                    hover:text-white
                    p-0
                    m-0
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-current w-6"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- single image  -->
          <template v-if="fields[field.id] && field.multiple != true">
            <div
              class="
                w-16
                h-16
                border border-slate-100
                shadow-sm
                rounded-md
                relative
                p-2
              "
            >
              <img
                v-show="fields[field]"
                v-transition
                :src="fields[field].url"
                class="w-full"
              />
              <div
                class="
                  absolute
                  top-0
                  left-0
                  w-full
                  h-full
                  overflow-hidden
                  flex
                  items-center
                  justify-center
                "
              >
                <button
                  @click.prevent="fields[field.id] = {}"
                  class="
                    w-6
                    h-6
                    bg-red-400
                    opacity-0
                    hover:opacity-100
                    rounded-md
                    flex
                    items-center
                    justify-center
                    text-xs text-gray-600
                    hover:text-white
                    p-0
                    m-0
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-current w-6"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </template>

          <template v-if="!fields[field.id] || field.multiple == true">
            <button
              @click="upload_image(field, field.multiple)"
              class="
                w-16
                h-16
                border border-slate-100
                shadow-sm
                rounded-md
                relative
                flex
                items-center
                justify-center
                text-xs text-gray-400
                hover:text-slate-600
                p-0
                m-0
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current w-6"
                viewBox="0 0 16 16"
              >
                <path
                  d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                />
              </svg>
            </button>
          </template>
        </div>
      </template>

      <!-- details -->
      <div
        class="text-xs text-slate-500"
        v-show="field.description"
        v-html="field.description"
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
  },
  data() {
    return {
      temp: {}
    };
  },
  computed: {
    isVisible() {
      return true;
    },
  },
  methods: {
    
  },
  mounted() {
    console.log(this.field);
  },
};
</script>