document.addEventListener("DOMContentLoaded", () => {
  const currentUrl = window.location.pathname.split("/").pop() || "index.php";
  const links = document.querySelectorAll(".nav-link");
  links.forEach((link) => {
    const linkHref = link.getAttribute("href");
    if (currentUrl === linkHref) {
      link.classList.add("nav-link-active");
      link.classList.remove("text-[#f0d8a8]");
    }
  });
});

function switchTab(tab) {
  const formLogin = document.getElementById("form-login");
  const formRegister = document.getElementById("form-register");
  const tabLogin = document.getElementById("tab-login");
  const tabRegister = document.getElementById("tab-register");

  if (tab === "login") {
    formLogin.classList.remove("hidden");
    formLogin.classList.add("block");
    formRegister.classList.remove("block");
    formRegister.classList.add("hidden");

    tabLogin.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#ffd700] bg-[#2d1e12] border-t-2 border-[#ffd700] transition-colors font-serif";
    tabRegister.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#b8860b] hover:text-[#f0d8a8] bg-[#1a120b] border-t-2 border-transparent transition-colors font-serif cursor-pointer";
  } else {
    formRegister.classList.remove("hidden");
    formRegister.classList.add("block");
    formLogin.classList.remove("block");
    formLogin.classList.add("hidden");

    tabRegister.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#ffd700] bg-[#2d1e12] border-t-2 border-[#ffd700] transition-colors font-serif";
    tabLogin.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#b8860b] hover:text-[#f0d8a8] bg-[#1a120b] border-t-2 border-transparent transition-colors font-serif cursor-pointer";
  }
}

function openModal(id) {
  const modal = document.getElementById(id);
  modal.classList.remove("hidden");
  setTimeout(() => {
    modal.classList.remove("opacity-0");
    modal.querySelector("div").classList.remove("scale-95");
  }, 10);
}

function closeModal(id) {
  const modal = document.getElementById(id);
  modal.classList.add("opacity-0");
  modal.querySelector("div").classList.add("scale-95");
  setTimeout(() => {
    modal.classList.add("hidden");
  }, 300);
}

function openEditUser(id, currentRole) {
  document.getElementById("edit_user_id").value = id;
  document.getElementById("edit_user_role").value = currentRole;
  openModal("modal-edit-user");
}

function openDeleteUser(id) {
  document.getElementById("delete_user_id").value = id;
  openModal("modal-delete-user");
}

function openEditGame(gameData) {
  if (gameData) {
    document.getElementById("game_modal_title").innerText =
      "Reforger le Grimoire";
    document.getElementById("form_game_id").value = gameData.id;
    document.getElementById("form_game_title").value = gameData.title;
    document.getElementById("form_game_year").value = gameData.release_year;
    document.getElementById("form_game_image").value = gameData.image;
    document.getElementById("form_game_diff").value = gameData.difficulty;
    document.getElementById("form_game_desc").value = gameData.description;

    // On pré-sélectionne le genre (si le jeu en possède un, on a récupéré le premier id)
    if (gameData.genre_id) {
      document.getElementById("form_game_genre").value = gameData.genre_id;
    }
  } else {
    document.getElementById("game_modal_title").innerText =
      "Forger un Nouveau Grimoire";
    document.getElementById("form_game_id").value = "";
    document.getElementById("form_game_title").value = "";
    document.getElementById("form_game_year").value = new Date().getFullYear();
    document.getElementById("form_game_image").value = "";
    document.getElementById("form_game_diff").value = "Medium";
    document.getElementById("form_game_desc").value = "";
    document.getElementById("form_game_genre").selectedIndex = 0; // Remet au premier genre par défaut
  }
  openModal("modal-edit-game");
}

function openDeleteGame(id) {
  document.getElementById("delete_game_id").value = id;
  openModal("modal-delete-game");
}
