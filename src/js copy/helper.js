import Swal from "sweetalert2";

export const Toast = Swal.mixin({
  confirmButtonColor: "#0d9488",
  customClass: {
    popup: "rounded-md",
    title: "font-medium tracking-normal text-gray-700",
    content: "text-base font-medium tracking-wide text-gray-600",
    confirmButton:
      "py-2 px-3 rounded-sm focus:ring-transparent focus:border-transparent",
    denyButton:
      "py-2 px-3 rounded-sm focus:ring-transparent focus:border-0 focus:border-transparent",
    cancelButton:
      "py-2 px-3 rounded-sm focus:ring-transparent focus:border-0 focus:border-transparent",
  },
  focusConfirm: false,
});

export const Loading = (message) => {
  return Toast.fire({
    title: message,
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showConfirmButton: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });
};

export const build_options = (options) => {
  let options_array = [];

  // check if options is an array
  if (Array.isArray(options)) {
    // check if options is an array of objects
    if (options.every((option) => typeof option === "object")) {
      // push each option to options_array with nullsafe 
      options.forEach((option) => {

        options_array.push({
          label: option.label || option.name || "",
          icon: option.icon || "",
          value: option.value || "",
        });
      }
      );
    }
  } else if (
    // check if options is an object
    typeof options === "object"
  ) {
    // push each option to options_array with nullsafe
    Object.keys(options).forEach((key) => {
      options_array.push({
        value: key || "", 
        label: options[key] || "",
      });
    }
    );
  }
 
  return options_array;
};
