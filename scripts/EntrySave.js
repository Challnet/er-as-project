class EntrySave {
  constructor() {
    this.forms = document.querySelectorAll(".modal form");

    if (!this.forms.length) return;

    this.bindSubmit();
  }

  bindSubmit() {
    this.forms.forEach(form => {
      form.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(form);

        const response = await fetch(form.action, {
          method: "POST",
          body: formData
        });

        let result;

        try {
          result = await response.json();
        } catch {
          this.showToast("Ошибка сервера — не получен JSON", true);
          return;
        }

        if (result.status === "success") {
          this.showToast("Сохранено");

          setTimeout(() => {

            window.location.href = result.redirect ?? "results.php";
          }, 1200);

        } else {
          this.showToast(result.message || "Ошибка сохранения", true);
        }
      });
    });
  }

  showToast(message, isError = false) {
    const container = document.getElementById("toast-container");

    const toast = document.createElement("div");
    toast.className = "toast-message " + (isError ? "error" : "success");
    toast.textContent = message;
    container.appendChild(toast);

    requestAnimationFrame(() => toast.classList.add("show"));

    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }
}

export default EntrySave;
