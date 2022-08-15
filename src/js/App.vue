<template>
  <div class="wrap february" :class="{ 'cursor-wait': isLoading }">
    <!-- February option page header  -->
    <div
      v-if="data.title || data.description"
      class="mb-1 sm:mb-4 flex flex-col gap-1 pv-3 py-2 sm:p-0"
    >
      <h2 v-if="data.title" class="font-medium text-xl text-slate-700 m-0">
        {{ data.title }}
      </h2>
      <p v-if="data.description" class="text-sm text-gray-500">
        {{ data.description }}
      </p>
    </div>

    <!-- February option page content -->
    <div
      class="february-wrapper"
      :class="{ 'pointer-events-none opacity-90 animate-pulse': isLoading }"
    >
      <!-- sidebar  -->
      <div @click="state.open = false" class="february-sidebar">
        <!-- responsive handler  -->
        <div class="february-sidebar-responsive-handler">
          <label v-text="data.label"></label>
          <button @click="state.open = !state.open">
            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
              <path
                v-if="!state.open"
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
              <path
                v-else
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
        </div>
        <!-- sidebar menu items  -->
        <nav
          :class="{ 'hidden sm:flex': !state.open }"
          class="february-sidebar-nav"
        >
          <!-- menu item  -->

          <a
            v-for="section in sections"
            :key="section.id"
            v-show="conditional_hide(section.condition)"
            @click="state.open = !state.open"
            class="february-sidebar-nav-item"
            :href="section.url ? section.url : '#' + section.id"
            :class="{ active: isHash(section.id) }"
            :target="section.target"
          >
            <i
              class="february-sidebar-nav-item-icon"
              :class="[
                section.icon,
                isHash(section.id) ? 'active' : 'inactive',
              ]"
            ></i>
            {{ section.title || section.id || "Untitled" }}
          </a>

          <!-- footer  -->
          <div class="february-sidebar-nav-credit">
            <a
              href="#"
              target="_blank"
              title="A Modern, Robust but Powerful WordPress Option Framework"
              >February Framework</a
            >
          </div>
        </nav>
      </div>

      <!-- sidebar ends  -->

      <!-- content  -->
      <div class="february-content">

        <!-- section header  -->

        <div class="february-content-header">
          <!-- section title  -->
          <div class="february-content-header-title">
            <div class="february-content-header-icon">
              <i :class="section.icon"></i>
            </div>
            <span v-text="section.title"></span>
          </div>
          <!-- save button -->
          <div>
            <button
              v-if="section.submit !== false"
              @click.prevent="saveOptions"
              :disabled="state.saving == true"
              class="february-btn"
            >
              <span
                class="dashicons"
                :class="[
                  state.saving
                    ? 'dashicons-update animate-spin'
                    : 'dashicons-saved',
                ]"
              ></span>
              <span>{{
                state.saving
                  ? data.saving || "Saving..."
                  : data.save || "Save Settings"
              }}</span>
            </button>
          </div>
        </div>

        <!-- header ends  -->

        <!-- section content -->

        <div class="february-content-body"  v-if="section && section.fields && section.fields.length">
         
         
         <!-- section fields  -->

          <Field v-for="field in section.fields" :key="field.id" :field="field" :section="section"></Field>    

          <!-- fields ends  -->
 

          <!-- Utility Tools -->

          <section
            v-if="data.tools != false && section && section.id === 'tools'"
          >
            <h2 class="font-medium text-base tracking-wide mb-2">
              Export Options
            </h2>

            <div class="text-slate-500 text-sm">
              You can Export all the options of
              <span class="font-medium" v-text="data.title"></span>
              as re-usable JSON file or copy to clipboard

              <div class="my-2">
                <textarea
                  @click.prevent="copySettings"
                  id="february-export-textarea"
                  placeholder="Your options here"
                  class="
                    february-editor
                    w-full
                    form-textarea
                    bg-slate-100
                    border-none
                    ring-1 ring-slate-200
                    focus:ring-slate-400 focus:bg-white
                    rounded-sm
                    text-sm
                    transition
                    duration-150
                    text-slate-600
                  "
                  rows="4"
                  readonly
                  v-model="JSONSettings"
                ></textarea>
              </div>
              <div class="mt-2 flex items-center gap-2">
                <button @click.prevent="copySettings" class="february-btn">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-clipboard-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm-2 0h1v1A2.5 2.5 0 0 0 6.5 5h3A2.5 2.5 0 0 0 12 2.5v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"
                    />
                  </svg>
                  Copy
                </button>
                <button @click.prevent="exportSettings" class="february-btn">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-file-earmark-arrow-down"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"
                    />
                    <path
                      d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"
                    />
                  </svg>
                  Download
                </button>
              </div>
            </div>

            <div class="border-b border-slate-100 my-6"></div>

            <h2 class="font-medium text-base tracking-wide mb-2">
              Import Options
            </h2>

            <div class="text-slate-500 text-sm mb-6">
              You can Import all the options for
              <span class="font-medium" v-text="data.title"></span> from JSON
              file or from Clipboard. Make sure, the JSON file generated through
              <span v-text="data.title"></span> Tool only. Importing a
              configuration will overwrite the existing options. Sometimes it
              may break your site. Do at your risk.

              <div class="my-2">
                <textarea
                  id="february-import-textarea"
                  @click.prevent="pasteSettings"
                  placeholder="Paste your options here"
                  class="
                    february-editor
                    w-full
                    form-textarea
                    bg-slate-100
                    border-none
                    ring-1 ring-slate-200
                    focus:ring-slate-400 focus:bg-white
                    rounded-sm
                    text-sm
                    transition
                    duration-150
                    text-slate-600
                  "
                  rows="4"
                  v-model="state.setting_data"
                ></textarea>
              </div>
              <div class="mt-2 flex items-center gap-2">
                <button
                  :class="{
                    'opacity-50 pointer-events-none': !state.setting_data,
                  }"
                  @click.prevent="importFromTextarea"
                  class="february-btn"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-file-earmark-arrow-up"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"
                    />
                    <path
                      d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"
                    />
                  </svg>

                  Import Options
                </button>
                <label for="february_import" class="february-btn">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-file-earmark-arrow-up"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"
                    />
                    <path
                      d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"
                    />
                  </svg>
                  Upload JSON</label
                >
                <input
                  id="february_import"
                  type="file"
                  class="hidden peer"
                  @input="importSettings"
                  accept=".json"
                />
              </div>
            </div>

            <div class="border-b border-slate-100 my-6"></div>

            <h2 class="font-medium text-base tracking-wide mb-2">
              Reset Options
            </h2>

            <div class="text-slate-500 text-sm">
              You can Reset all the options for
              <span class="font-medium" v-text="data.title"></span>. It will
              revert to default settings and remove all the customizations you
              made later. Make sure you have have exported the options before
              resetting.

              <div class="mt-2 flex items-center gap-2">
                <button
                  class="february-btn danger"
                  @click.prevent="resetSettings"
                  :disabled="state.settingsResetting == true"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-clockwise"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"
                    />
                    <path
                      d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"
                    />
                  </svg>
                  Reset to default
                </button>
              </div>
            </div>
          </section>
        </div>

        <!-- content ends  -->

        <!-- section footer -->

        <div v-show="section.submit !== false" class="february-content-header">
          <div class="february-content-header-notice">
            <button
              @click.prevent="resetSection"
              :disabled="state.saving == true"
              class="february-btn danger"
            >
              <span
                v-text="
                  state.sectionResetting
                    ? data.resetting || 'Resetting...'
                    : data.reset || 'Reset Section'
                "
              ></span>
            </button>
          </div>
          <div>
            <button
              @click.prevent="saveOptions"
              :disabled="state.saving == true"
              class="february-btn"
            >
              <span
                class="dashicons"
                :class="[
                  state.saving
                    ? 'dashicons-update animate-spin'
                    : 'dashicons-saved',
                ]"
              ></span>
              <span
                v-text="
                  state.saving
                    ? data.saving || 'Saving...'
                    : data.save || 'Save Options'
                "
              ></span>
            </button>
          </div>
        </div>

        <!-- footer ends  -->

      </div>
    </div>
  </div>
</template>

<script>
import { Toast, Loading } from './helper';
import Field from "./component/field.vue";


export default {
  name: 'february',
  components: {
    Field
  },
  data() {
    return {
      state: {},

      hash: window.location.hash || "",

      fields: {},

      data: {},
    };
  },
  computed: {
    toolSection() {
      return {
        id: "tools",
        title: this.data.tools_label || "Utility Tools",
        icon: "dashicons dashicons-admin-tools",
        submit: false,
      };
    },

    sections() {
      let sections = this.data.sections || [];
      if (
        this.data.tools != false &&
        !sections.find((section) => section.id === "tools")
      )
        sections.push(this.toolSection);

      return sections.map((section) => {
        section.id = section.id || section.label.toLowerCase() || "undefined";
        section.title =
          section.title || section.id.toUpperCase() || "Undefined";
        section.icon =
          section.icon || section.icon || "dashicons dashicons-admin-generic";
        section.target = section.target || "_top";
        return section;
      });
    },

    section() {
      return this.sections.find((section) => section.id === this.getHash) || {};
    },

    getHash() {
      let hash = this.state.hash;
      hash = hash ? hash.replace("#", "") : "/";
      return hash;
    },

    defaultSection() {
      if (this.data.default_section) return this.data.default_section;
      if (this.sections && this.sections.length) return this.sections[0].id;
    },

    isLoading() {
      return (
        this.state.settingsExporting ||
        this.state.settingsImporting ||
        this.state.settingsSaving ||
        this.state.settingsLoading ||
        this.state.settingsResetting
      );
    },

    JSONSettings() {
      return JSON.stringify(this.fields);
    },
  },
  created() {
    if (typeof february_data === "object") {
      this.data = february_data;
      console.log(february_data);
    }

    window.addEventListener("hashchange", () => {
      this.state.hash = window.location.hash;
    });

    let hash = window.location.hash || this.defaultSection;
    // console.log(this.section);
    if (hash) {
      hash = hash.toString().replace("#", "");
      window.location.hash = hash;
      this.state.hash = window.location.hash;
    }

    this.initializeForm();
  },
  methods: {
    initializeForm() {
      let fields = {};

      fields = this.sections
        .filter((section) => section.fields)
        .map((section) => section.fields)
        .reduce((a, b) => a.concat(b), [])
        .filter((field) =>
          Object.values(this.data.input_fields).includes(field.type)
        );

      let initializedFields = {};
      fields.forEach((field) => {
        initializedFields[field.id] =
          field.value ||
          (["multi_checkbox", "multi_switch"].includes(field.type) ? {} : "");
      });

      this.fields = initializedFields;
    },

    initializeDefaultValues() {
      let fields = {};

      fields = this.sections

        .filter((section) => section.fields)
        .map((section) => section.fields)
        .reduce((a, b) => a.concat(b), [])
        .filter((field) =>
          Object.values(this.data.input_fields).includes(field.type)
        );

      let initializedFields = {};
      fields.forEach((field) => {
        initializedFields[field.id] =
          field.default ||
          (["multi_checkbox", "multi_switch"].includes(field.type) ? {} : "");
      });

      this.fields = initializedFields;
    },

    isHash(hash = "") {
      let currentHash = this.state.hash;
      return (
        currentHash === hash || (currentHash && currentHash === "#" + hash)
      );
    },

    async resetSection() {
      this.sectionResetting = true;
      Toast.fire({
        title: "Reset to section?",
        html: `You will lose all your options of this section and this can not be undone. <br> <strong>Please backup your options before proceeding.</strong>`,
        showCancelButton: true,
        cancelButtonColor: "#aaa",
        confirmButtonColor: "#d33",
        confirmButtonText: "Reset section",
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.state.settingsResetting = true;
          Loading("Resetting section...");
          console.log(this.section);

          this.section.fields.forEach((field) => {
            this.fields[field.id] =
              field.default ||
              (["multi_checkbox", "multi_switch"].includes(field.type)
                ? {}
                : "");
          });

          let data = {
            nonce: this.data.nonce,
            options: this.fields,
            id: this.data.id,
            action: "february_save_options",
          };

          let response = await fetch(
            this.data.ajax_url + "?action=february_save_options",
            {
              method: "POST",
              headers: {
                "Content-Type": "application/v-www-form-urlencoded",
              },
              body: JSON.stringify(data),
            }
          );

          response = await response.json();

          console.log(response);

          if (response.success) {
            this.state.settingsResetting = false;
            Toast.fire({
              toast: true,
              title: "Section has been reset!",
              icon: "success",
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
          } else {
            this.state.settingsResetting = false;
            Toast.fire({
              toast: true,

              title: "Something went wrong!",
              icon: "error",
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
          }
        }
      });
    },

    async saveOptions() {
      this.state.settingsSaving = true;

      let data = {
        nonce: this.data.nonce,
        options: this.fields,
        id: this.data.id,
        action: "february_save_options",
      };

      let response = await fetch(
        this.data.ajax_url + "?action=february_save_options",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/v-www-form-urlencoded",
          },
          body: JSON.stringify(data),
        }
      );

      response = await response.json();

      console.log(response);

      if (response.success) {
        this.state.settingsSaving = false;
        Toast.fire({
          toast: true,
          title: "Settings have been saved!",
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        });
      } else {
        this.state.settingsSaving = false;
        Toast.fire({
          toast: true,

          title: "Something went wrong!",
          icon: "error",
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        });
      }
    },

    conditional(condition = null) {
      // return if condition is not set
      if (!condition) return true;
      // replace all variables
      condition = condition.replace(/\$([a-zA-Z0-9_]+)/g, "this.fields.$1");

      // evaluate condition using eval
      try {
        let result = eval(condition);
        return result;
      } catch (e) {
        return false;
      }
    },

    conditional_hide(condition = null) {
      return this.conditional(condition);
    },

    conditional_fade(condition = null) {
      return !this.conditional(condition);
    },

    build_options(options = []) {
      return build_options(options);
    },

    upload_image(field = "", multiple = false) {
      console.log("Uploading image...", multiple);

      const self = this;
      const uploader = wp
        .media({
          title: field.title || "Choose Image" + (multiple ? "s" : ""),
          button: {
            text: field.title || "Choose Image" + (multiple ? "s" : ""),
          },
          multiple: multiple || false,
        })
        .on("select", function () {
          const attachments = uploader.state().get("selection").toJSON();

          if (multiple) {
            self.fields[field.id] = attachments.map((attachment) => {
              return {
                id: attachment.id,
                url: attachment.url,
                full: attachment.sizes.full.url,
                thumbnail: attachment.sizes.thumbnail.url,
                medium: attachment.sizes.medium.url,
                caption: attachment.caption,
                alt: attachment.alt,
                mime: attachment.mime,
              };
            });
          } else {
            let attachment = attachments[0];

            self.fields[field.id] = {
              id: attachment.id,
              url: attachment.url,
              full: attachment.sizes.full.url,
              thumbnail: attachment.sizes.thumbnail.url,
              medium: attachment.sizes.medium.url,
              caption: attachment.caption,
              alt: attachment.alt,
              mime: attachment.mime,
            };
          }
        })
        .open();
    },

    async importSettings(event) {
      // read file from event
      let file = event.target.files[0];
      event.target.value = null;
      let reader = new FileReader();
      reader.onload = async (e) => {
        let data = e.target.result;

        try {
          data = JSON.parse(data);
          // confirm swal
          Toast.fire({
            title: "Import settings?",
            html: `You will lose all your settings and this can not be undone. <br> <strong>Please backup your settings before proceeding.</strong>`,
            showCancelButton: true,
            confirmButtonText: "Import settings",
          }).then(async (result) => {
            if (result.isConfirmed) {
              this.state.settingsImporting = true;

              this.fields = data;
              await this.saveOptions();

              this.state.settingsImporting = false;
              Toast.fire({
                toast: true,
                title: "Settings have been imported!",
                icon: "success",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
              });
            }
          });
        } catch (e) {
          Toast.fire({
            icon: "error",
            title: "Invalid JSON file!",
          });
          return;
        }
      };
      reader.readAsText(file);
    },

    async exportSettings() {
      this.state.settingsExporting = true;
      let formatedValues = {};
      let fields = this.sections
        .filter((section) => section.fields)
        .map((section) => section.fields)
        .reduce((a, b) => a.concat(b), [])
        .filter((field) =>
          Object.values(this.data.input_fields).includes(field.type)
        )
        .map((field) => {
          formatedValues[field.id] = field.value;
        });

      var dataStr =
        "data:text/json;charset=utf-8," +
        encodeURIComponent(JSON.stringify(formatedValues));
      var downloadAnchorNode = document.createElement("a");
      downloadAnchorNode.setAttribute("href", dataStr);
      downloadAnchorNode.setAttribute(
        "download",
        february_data.id + "-options.json"
      );
      document.body.appendChild(downloadAnchorNode); // required for firefox
      downloadAnchorNode.click();
      downloadAnchorNode.remove();
      this.state.settingsExporting = false;
    },
    async copySettings() {
      let fields = this.fields;
      // copy field to clipboard using browser navigator
      document.querySelector("#february-export-textarea").select();
      navigator.clipboard.writeText(JSON.stringify(fields));
      Toast.fire({
        toast: true,
        title: "Copied to clipboard!",
        icon: "success",
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });
    },
    async pasteSettings() {
      // paste field from clipboard using browser navigator
      let text = await navigator.clipboard.readText();

      try {
        let isJSON = JSON.parse(text);
        if (isJSON && text) {
          this.state.setting_data = text;
          this.importFromTextarea();
        }
      } catch (e) {
        return;
      }
    },
    async importFromTextarea() {
      try {
        let data = JSON.parse(this.state.setting_data);
        // confirm swal
        Toast.fire({
          title: "Import settings?",
          html: `You will lose all your settings and this can not be undone. <br> <strong>Please backup your settings before proceeding.</strong>`,
          showCancelButton: true,
          confirmButtonText: "Import settings",
        }).then(async (result) => {
          if (result.isConfirmed) {
            this.state.settingsImporting = true;

            this.fields = data;
            await this.saveOptions();

            this.state.settingsImporting = false;
            this.state.setting_data = "";

            Toast.fire({
              toast: true,
              title: "Options have been imported!",
              icon: "success",
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
          }
        });
      } catch (e) {
        Toast.fire({
          icon: "error",
          title: "Invalid options!",
        });
        return;
      }
    },
    async resetSettings() {
      Toast.fire({
        title: "Reset to default options?",
        html: `You will lose all your options and this can not be undone. <br> <strong>Please backup your options before proceeding.</strong>`,
        showCancelButton: true,
        cancelButtonColor: "#aaa",
        confirmButtonColor: "#d33",
        confirmButtonText: "Reset options",
      }).then(async (result) => {
        if (result.isConfirmed) {
          Toast.fire({
            title: "Are you sure you want to reset all options?",

            icon: "warning",
            showCancelButton: true,

            cancelButtonColor: "#aaa",
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, reset it!",
          }).then(async (result) => {
            if (result.isConfirmed) {
              this.state.settingsResetting = true;
              Loading("Resetting...");

              this.initializeDefaultValues();

              let data = {
                nonce: this.data.nonce,
                id: this.data.id,
                options: this.fields,
                action: "february_save_options",
              };

              console.log(data);

              let response = await fetch(
                this.data.ajax_url + "?action=february_save_options",
                {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/v-www-form-urlencoded",
                  },
                  body: JSON.stringify(data),
                }
              );

              response = await response.json();

              console.log(response);

              if (response.success) {
                this.state.settingsResetting = false;
                Toast.fire({
                  toast: true,
                  title: "Settings have been reset!",
                  icon: "success",
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                });
              } else {
                this.state.settingsResetting = false;
                Toast.fire({
                  toast: true,

                  title: "Something went wrong!",
                  icon: "error",
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                });
              }
            }
          });
        }
      });
    },
  },
};
</script>