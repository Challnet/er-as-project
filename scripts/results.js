class ResultsManager {
  selectors = {
    addButton: ".add-result-btn",
    deleteButton: ".delete-result-btn",
    toastContainerId: "toast-container",
  };

  constructor() {
    this.createToastContainer();
    this.bindCreateButtons();
    this.bindDeleteButtons();
  }

  bindCreateButtons() {
    document.querySelectorAll(this.selectors.addButton).forEach(btn => {
      btn.addEventListener("click", async () => {
        const year = btn.dataset.year;

        const response = await fetch("src/actions/create-result.php", {
          method: "POST",
          body: new URLSearchParams({ year })
        });

        const result = await response.json();

        if (result.status === "success") {
          this.showToast("Запись создана");
          setTimeout(() => window.location.reload(), 900);
        } else {
          this.showToast(result.message, true);
        }
      });
    });
  }

  bindDeleteButtons() {
    document.addEventListener("click", async (event) => {
      if (!event.target.matches(this.selectors.deleteButton)) return;

      if (!confirm("Удалить запись?")) return;

      const id = event.target.dataset.id;
      const year = event.target.dataset.year;

      const response = await fetch("src/actions/delete-result.php", {
        method: "POST",
        body: new URLSearchParams({ id, year })
      });

      const result = await response.json();

      if (result.status === "success") {
        this.showToast("Удалено");
        setTimeout(() => window.location.reload(), 600);
      } else {
        this.showToast(result.message, true);
      }
    });
  }

  createToastContainer() {
    if (!document.getElementById(this.selectors.toastContainerId)) {
      const container = document.createElement("div");
      container.id = this.selectors.toastContainerId;
      document.body.appendChild(container);
    }
  }

  showToast(message, isError = false) {
    const container = document.getElementById(this.selectors.toastContainerId);
    const toast = document.createElement("div");

    toast.className = "toast-message" + (isError ? " error" : " success");
    toast.textContent = message;

    container.appendChild(toast);

    requestAnimationFrame(() => toast.classList.add("show"));

    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }
}


export default ResultsManager;
