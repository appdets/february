import Alpine from "alpinejs";
import February from "./february";  

// start alpine js
(function () {
  window.Alpine = Alpine;

  // managing router
  Alpine.magic("router", () => {
    const isURL = (url) => {
      try {
        new URL(url);
        return true;
      } catch (e) {
        return false;
      }
    };

    return {
      push(route, target = "_self") {
        if (isURL(route)) {
          // open route in new tab
          window.open(route, target);
        } else {
          window.location.hash = route;
        }
      },
      redirect(url, target = "_top") {
        window.open(url, target);
      },
    };
  });

  Alpine.data("February", February);

  Alpine.directive("log", (el, { expression }, { evaluateLater, effect }) => {
    let getThingToLog = evaluateLater(expression);

    effect(() => {
      getThingToLog((thingToLog) => {
        console.log(thingToLog);
      });
    });
  });
  Alpine.start();
})(Alpine);
