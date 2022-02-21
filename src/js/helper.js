import Swal from "sweetalert2";

export const Toast = Swal.mixin({
  confirmButtonColor: "#0d9488",
  customClass: {
    popup: "rounded-md", 
    title: 'font-medium tracking-normal text-gray-700',
    content: 'text-base font-medium tracking-wide text-gray-600',
    confirmButton: 'py-2 px-3 rounded-sm focus:ring-transparent focus:border-transparent',
    denyButton: 'py-2 px-3 rounded-sm focus:ring-transparent focus:border-0 focus:border-transparent',
    cancelButton: 'py-2 px-3 rounded-sm focus:ring-transparent focus:border-0 focus:border-transparent',
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
