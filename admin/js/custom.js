document.addEventListener("DOMContentLoaded", function () {
  // Toggle sidebar
  document
    .getElementById("sidebarCollapse")
    .addEventListener("click", function () {
      document.getElementById("sidebar").classList.toggle("active");
      document.getElementById("content").classList.toggle("active");
    });

  document
    .querySelectorAll(".more-button, .body-overlay")
    .forEach(function (element) {
      element.addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("show-nav");
        document.querySelector(".body-overlay").classList.toggle("show-nav");
      });
    });

  // Load content using AJAX
  document.querySelectorAll(".load-content").forEach(function (element) {
    element.addEventListener("click", function (e) {
      e.preventDefault();
      var target = this.getAttribute("data-target");
      var xhr = new XMLHttpRequest();
      xhr.open("GET", target, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById("main-content").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    });
  });
});
