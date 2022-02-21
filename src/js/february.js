import {Toast, Loading} from "./helper"

const February = {
  // state
  state: {},

  hash: window.location.hash || "",

  fields: {},

  // data
  data: {},

  get toolSection() {
    return {
      id: "tools",
      label: "Utility Tools",
      icon: "dashicons dashicons-admin-tools",
    };
  },

  get sections() {
    let sections = this.data.sections || [];
    if (
      this.data.tools &&
      !sections.find((section) => section.id === "tools")
    )
      sections.push(this.toolSection);

    return sections.map((section) => {
      section.id = section.id || section.label.toLowerCase() || "undefined";
      section.label =
        section.label || section.id.toUpperCase() || "Undefined";
      section.icon =
        section.icon || section.icon || "dashicons dashicons-admin-generic";
      section.target = section.target || "_top";
      return section;
    });
  },

  get section() {
    return this.sections.find((section) => section.id === this.getHash) || {};
  },

  get getHash() {
    let hash = this.state.hash;
    hash = hash ? hash.replace("#", "") : "/";
    return hash;
  },

  get defaultSection() {
    if (this.data.default) return this.data.default;
    if (this.sections && this.sections.length) return this.sections[0].id;
  },

  get isLoading(){
    return this.state.settingsExporting || this.state.settingsImporting || this.state.settingsSaving || this.state.settingsLoading || this.state.settingsResetting;
  },

  // init
  init() {
    if (typeof FebruaryData === "object") this.data = FebruaryData;

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

  initializeForm() {
    let allFields = {};

    this.sections
      .filter((section) => section.fields && section.fields.length)
      .map((section) => section.fields)
      .forEach((fields) => {
        fields.forEach((field) => {
          allFields[field.name] = field.default || field.value || "";
        });
      });

    this.fields = allFields;
  },

  isHash(hash = "") {
    let currentHash = this.state.hash;
    return currentHash === hash || (currentHash && currentHash === "#" + hash);
  },

  async saveOptions() {
    this.state.saving = true;
    console.log(this.fields);
    setTimeout(() => {
      this.state.saving = false;
    }, 2000);
  },

  // tools

  async importSettings() {
    this.state.settingsImporting = true;
    setTimeout(() => {
      this.state.settingsImporting = false;
    }, 3000);
  },
  async exportSettings() {
    this.state.settingsExporting = true;
    setTimeout(() => {
      this.state.settingsExporting = false;
    }, 3000);
  },
  async resetSettings() {
    Toast.fire({
      icon: "warning",
      title: "Reset to default settings?",
      html: `You will lose all your settings and this can not be undone. <br> <strong>Please backup your settings before proceeding.</strong>`,
      showCancelButton: true,
      confirmButtonColor: "#0d9488",
      cancelButtonColor: "#d33",
      confirmButtonText: "Reset settings",
    }).then((result) => {
      if (result.isConfirmed) {
        Toast.fire({
          title: "Are you sure you want to reset all settings?",
          
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#0d9488",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, reset it!",
        }).then((result) => {
          if (result.isConfirmed) {
            this.state.settingsResetting = true;
            Loading('Loading your settings...') 
            setTimeout(() => {
              this.state.settingsResetting = false;
              Toast.fire({
                toast: true,
                title: "Settings have been reset!",
                icon: "success",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
              });
            }, 3000);
          }
        }) 
      }
    });
  },
};

export default () => February;
