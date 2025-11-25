class EntriesManager {
  selectors = {
    deleteButton: ".delete-btn",
    createButton: ".add-entry-btn",
    toastContainerId: "toast-container",
  };

  constructor() {
    this.createToastContainer();
    this.bindDeleteButtons();
    this.bindCreateButtons();
  }

  /** -------------------- Удаление -------------------- */
  bindDeleteButtons() {
    document.addEventListener("click", (event) => {
      if (!event.target.matches(this.selectors.deleteButton)) return;

      const button = event.target;

      if (!confirm("Удалить запись?")) return;

      const year = button.dataset.year;
      const id = button.dataset.id;
      const listItem = button.closest("li");

      this.deleteEntry(year, id, listItem);
    });
  }

  async deleteEntry(year, id, listItem) {
    try {
      const response = await fetch("src/actions/delete-entry.php", {
        method: "POST",
        body: new URLSearchParams({ year, id }),
      });

      const result = await response.json();

      if (result.status === "success") {
        this.fadeOut(listItem);
        this.showToast("Запись удалена");
      } else {
        this.showToast(result.message || "Ошибка удаления", true);
      }
    } catch {
      this.showToast("Ошибка соединения с сервером", true);
    }
  }

  fadeOut(element) {
    element.style.transition = "0.3s";
    element.style.opacity = "0";
    setTimeout(() => element.remove(), 300);
  }

  /** -------------------- Создание -------------------- */
  bindCreateButtons() {
    document.querySelectorAll(this.selectors.createButton).forEach(btn => {
      btn.addEventListener("click", async () => {

        const year = btn.dataset.year;

        const res = await fetch("src/actions/create-entry.php", {
          method: "POST",
          body: new URLSearchParams({ year })
        });

        const data = await res.json();

        if (data.status === "success") {
          this.showToast("Создано новое объявление");

          setTimeout(() => location.reload(), 1200); // чтобы анимация toast показалась
        } else {
          this.showToast(data.message, true);
        }
      });
    });
  }

  /** -------------------- TOAST -------------------- */
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
    toast.classList.add("toast-message", isError ? "error" : "success");
    toast.textContent = message;

    container.appendChild(toast);

    // Анимация появления
    setTimeout(() => toast.classList.add("show"), 10);

    // Исчезает через 6 сек
    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, 6000);
  }
}

export default EntriesManager;
