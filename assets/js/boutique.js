document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="boutique.php"]');
    const catalogue = document.querySelector('.catalogue');

    // 🔹 Auto-submit quand on change un select
    form.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function () {
            form.dispatchEvent(new Event('submit'));
        });
    });

    // 🔹 AJAX pour le formulaire
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const url = form.action + '?' + new URLSearchParams(new FormData(form));
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                catalogue.innerHTML = html;
                history.pushState({}, '', url); // ✅ met à jour l'URL avec les bons paramètres
            })
            .catch(err => console.error('Erreur AJAX formulaire :', err));
    });

    // 🔹 AJAX pour pagination
    document.addEventListener('click', function (e) {
        if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
            e.preventDefault();
            const url = e.target.href; // ✅ garde bien l'URL cliquée
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    catalogue.innerHTML = html;
                    history.pushState({}, '', url); // ✅ maintenant la page dans l'URL est correcte
                })
                .catch(err => console.error('Erreur AJAX pagination :', err));
        }
    });

    // 🔹 Gère le bouton retour/avant du navigateur
    window.addEventListener('popstate', function () {
        fetch(location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                catalogue.innerHTML = html;
            })
            .catch(err => console.error('Erreur AJAX popstate :', err));
    });

});
