window.FebruaryData = {
  id: "february",
  label: "February UI",
  default: false,
  tools: true,
  credit: `By <a href="#" target="_blank" title="A Modern, Robust but Powerful WordPress Option Framework for Plugins / Themes">February Framework</a>`,
  sections: [
    {
      id: "general",
      label: "General Settings",
      condition: "",
      submit: true,
      fields: [
        {
          type: "text",
          id: "name",
          label: "Full name",
          default: "John Doe",
          placeholder: "Enter your name",
          hints: "Please enter your Full Name",
          pattern: "",
          before: "",
          after: "",
          readonly: 0,
          disabled: 0,
          attr: {},
          required: 1,
          details: "This is a dummy details description bellow the field",
          class: ["test"],
          condition: "",
        },
        {
          type: "space",          
        },
        {
          type: "tab",
          label: "Kire vai",
          id: "name2",
          default: "center",
          options: [
            {
              icon: "dashicons dashicons-align-left",
              value: "left",
            },
            {
              icon: "dashicons dashicons-align-center",
              value: "center",
            },
            {
              icon: "dashicons dashicons-align-right",
              value: "right",
            },
          ],
        },
      ],
    },
    {
      id: "advanced",
      label: "Advanced Settings",
      icon: "dashicons dashicons-admin-settings",
      submit: true,
      condition: "",
      fields: [
        {
          type: "select",
          id: "name3",
          label: "Name",
          placeholder: "Select your name",
          required: 1,
          options: [
            {
              label: "Option 1",
              value: "option1",
            },
            {
              label: "Option 2",
              value: "option2",
            },
            {
              label: "Option 3",
              value: "option3",
            },
          ],
          class: ["test"],
          condition: "",
        },
      ],
    },
   
    {
      id: "about",
      label: "About February",
      icon: "dashicons dashicons-info",
      condition: "",
      full: true,
      fields: [
        {
          id: "about",
          type: "html",
          html: `This is dummy message for February. You can use this section to add any kind of information about February. Goto <a href="#" target="_blank">February Framework</a> for more details.`,
          label: "Dummy HTML",
          class: ["test"],
          condition: "",
        },
      ],
    },

    {
      label: "Visit Support",
      url: "http://facebook.com",
      target: "_blank",
      icon: "dashicons dashicons-external",
    },
  ],
};