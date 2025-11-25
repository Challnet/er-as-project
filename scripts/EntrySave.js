class EntrySave {
  constructor() {
    this.form = document.querySelector("#content-modal form");
    if (!this.form) return;

    this.bindSubmit();
  }

  bindSubmit() {
    this.form.addEventListener("submit", async (event) => {
      event.preventDefault();

      const formData = new FormData(this.form);

      const response = await fetch(this.form.action, {
        method: "POST",
        body: formData
      });

      const result = await response.json();

      if (result.status === "success") {
        this.showToast("Запись успешно сохранена");

        setTimeout(() => {
          window.location.href = "service.php";
        }, 1800);
      } else {
        this.showToast(result.message || "Ошибка сохранения", true);
      }
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
