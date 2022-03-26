import { Toast, Loading, build_options } from "./helper";

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
      title: this.data.tools_label || "Utility Tools",
      icon: "dashicons dashicons-admin-tools",
      submit: false,
    };
  },

  get sections() {
    let sections = this.data.sections || [];
    if (
      this.data.tools != false &&
      !sections.find((section) => section.id === "tools")
    )
      sections.push(this.toolSection);

    return sections.map((section) => {
      section.id = section.id || section.label.toLowerCase() || "undefined";
      section.title = section.title || section.id.toUpperCase() || "Undefined";
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
    if (this.data.default_section) return this.data.default_section;
    if (this.sections && this.sections.length) return this.sections[0].id;
  },

  get isLoading() {
    return (
      this.state.settingsExporting ||
      this.state.settingsImporting ||
      this.state.settingsSaving ||
      this.state.settingsLoading ||
      this.state.settingsResetting
    );
  },

  get JSONSettings() {
    return JSON.stringify(this.fields);
  },

  // init
  init() {
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
    return currentHash === hash || (currentHash && currentHash === "#" + hash);
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
            (["multi_checkbox", "multi_switch"].includes(field.type) ? {} : "");
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
              "Content-Type": "application/x-www-form-urlencoded",
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
          "Content-Type": "application/x-www-form-urlencoded",
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
                  "Content-Type": "application/x-www-form-urlencoded",
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
};

export default () => February;
