import moment from "moment/moment";
export default {
    install: (app) => {
      // Add $swal instance to the Vue app prototype
      app.config.globalProperties.$moment = moment;
    },
  };