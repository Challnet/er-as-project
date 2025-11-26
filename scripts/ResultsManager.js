class ResultsManager {

  constructor() {
    this.bindCreate();
    this.bindDelete();
  }

  bindCreate() {
    document.querySelectorAll(".add-result-btn").forEach(btn => {
      btn.onclick = async () => {
        const year = btn.dataset.year;
        const res = await fetch("src/actions/create-result.php", {
          method: "POST",
          body: new URLSearchParams({year})
        });

        const data = await res.json();
        if (data.status === "success") location.reload();
      };
    });
  }

  bindDelete() {
    document.addEventListener("click", async e => {
      if (!e.target.matches(".delete-result-btn")) return;

      if (!confirm("Удалить запись?")) return;

      const year = e.target.dataset.year;
      const id = e.target.dataset.id;

      const res = await fetch("src/actions/delete-result.php", {
        method: "POST",
        body: new URLSearchParams({year, id})
      });

      const data = await res.json();
      if (data.status === "success") location.reload();
    });
  }
}

export default ResultsManager;
