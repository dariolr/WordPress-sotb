/**
 * Sons of the Beach — Admin "Scuole & Location"
 * Pure vanilla JS. Talks directly to the existing PHP APIs in
 * _php/php_sotb/ (admin_scuole.php, admin_locations.php); this WP admin
 * page is only the access gate (Amministratore) and the UI.
 */
(function () {
  'use strict';

  var config = window.sotbAdminConfig || {};
  var listKeyByEntity = { scuole: 'scuole', location: 'locations' };
  var currentPanel = null;

  function apiUrl(endpoint, params) {
    var url = new URL(config.apiBase + endpoint);
    url.searchParams.set('token', config.token);
    Object.keys(params || {}).forEach(function (key) {
      url.searchParams.set(key, params[key]);
    });
    return url.toString();
  }

  function showNotice(panel, message, isError) {
    var notice = panel.querySelector('.sotb-admin-notice');
    notice.textContent = message;
    notice.classList.toggle('sotb-admin-notice--error', !!isError);
    notice.hidden = false;
    setTimeout(function () {
      notice.hidden = true;
    }, 4000);
  }

  function escapeHtml(value) {
    var div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
  }

  function renderRows(panel, items) {
    var tbody = panel.querySelector('.sotb-admin-tbody');
    if (!items.length) {
      tbody.innerHTML = '<tr><td colspan="5">Nessuna scheda presente.</td></tr>';
      return;
    }

    tbody.innerHTML = items
      .map(function (item) {
        var enabled = String(item.abilita) === '1';
        return (
          '<tr data-id="' + item.id + '">' +
          '<td>' + escapeHtml(item.nome) + '</td>' +
          '<td>' + escapeHtml(item.citta) + '</td>' +
          '<td>' + (item.booking ? '✅' : '—') + '</td>' +
          '<td>' + (enabled ? '✅' : '⏸️') + '</td>' +
          '<td>' +
          '<button type="button" class="button button-small sotb-edit">Modifica</button> ' +
          '<button type="button" class="button button-small sotb-toggle">' + (enabled ? 'Disattiva' : 'Attiva') + '</button> ' +
          '<button type="button" class="button button-small button-link-delete sotb-delete">Elimina</button>' +
          '</td>' +
          '</tr>'
        );
      })
      .join('');

    tbody.querySelectorAll('tr').forEach(function (row) {
      var item = items.find(function (i) {
        return String(i.id) === row.getAttribute('data-id');
      });
      row.querySelector('.sotb-edit').addEventListener('click', function () {
        openModal(panel, item);
      });
      row.querySelector('.sotb-toggle').addEventListener('click', function () {
        toggleItem(panel, item);
      });
      row.querySelector('.sotb-delete').addEventListener('click', function () {
        deleteItem(panel, item);
      });
    });
  }

  function loadList(panel) {
    var entity = panel.getAttribute('data-entity');
    var endpoint = panel.getAttribute('data-endpoint');
    fetch(apiUrl(endpoint, { action: 'list' }))
      .then(function (res) {
        return res.json();
      })
      .then(function (json) {
        var items = (json.dati && json.dati[listKeyByEntity[entity]]) || [];
        renderRows(panel, items);
      })
      .catch(function () {
        showNotice(panel, 'Errore nel caricamento dei dati.', true);
      });
  }

  function toggleItem(panel, item) {
    var endpoint = panel.getAttribute('data-endpoint');
    var action = String(item.abilita) === '1' ? 'disable' : 'enable';
    var body = new URLSearchParams();
    body.set('token', config.token);
    body.set('action', action);
    body.set('id', item.id);

    fetch(config.apiBase + endpoint, { method: 'POST', body: body })
      .then(function (res) {
        return res.json();
      })
      .then(function (json) {
        if (json.status === 'ok') {
          showNotice(panel, 'Aggiornato.');
          loadList(panel);
        } else {
          showNotice(panel, json.error || 'Errore.', true);
        }
      });
  }

  function deleteItem(panel, item) {
    if (!window.confirm('Eliminare definitivamente "' + item.nome + '"? L\'azione non è reversibile.')) {
      return;
    }
    var endpoint = panel.getAttribute('data-endpoint');
    var body = new URLSearchParams();
    body.set('token', config.token);
    body.set('action', 'delete');
    body.set('id', item.id);

    fetch(config.apiBase + endpoint, { method: 'POST', body: body })
      .then(function (res) {
        return res.json();
      })
      .then(function (json) {
        if (json.status === 'ok') {
          showNotice(panel, 'Eliminato.');
          loadList(panel);
        } else {
          showNotice(panel, json.error || 'Errore.', true);
        }
      });
  }

  /* ============================================================
     MODAL / FORM
     ============================================================ */
  var modal = document.getElementById('sotb-admin-modal');
  var form = modal ? modal.querySelector('.sotb-admin-form') : null;

  function openModal(panel, item) {
    currentPanel = panel;
    var entity = panel.getAttribute('data-entity');
    modal.querySelector('.sotb-admin-modal-title').textContent = item
      ? 'Modifica ' + (entity === 'scuole' ? 'scuola' : 'location')
      : 'Nuova ' + (entity === 'scuole' ? 'scuola' : 'location');

    // "app" (link allo store) esiste solo per T_SCUOLE, non per T_LOCATION.
    form.querySelectorAll('.sotb-field-scuole-only').forEach(function (row) {
      row.hidden = entity !== 'scuole';
    });

    form.reset();
    form.querySelectorAll('.sotb-admin-preview').forEach(function (img) {
      img.hidden = true;
      img.src = '';
    });

    form.elements.id.value = item ? item.id : '';
    [
      'nome', 'indirizzo', 'citta', 'latitudine', 'longitudine', 'telefono',
      'whatsapp', 'email', 'sitoweb', 'booking', 'ecommerce', 'app',
      'titolo_chi_siamo', 'descrizione',
    ].forEach(function (field) {
      if (item && form.elements[field] !== undefined && item[field] !== undefined) {
        form.elements[field].value = item[field];
      }
    });
    form.elements.abilita.checked = item ? String(item.abilita) === '1' : true;
    form.elements.in_evidenza.checked = item ? String(item.in_evidenza) === '1' : false;

    modal.hidden = false;
  }

  function closeModal() {
    modal.hidden = true;
    currentPanel = null;
  }

  if (modal) {
    modal.querySelector('.sotb-admin-modal-close').addEventListener('click', closeModal);
    modal.querySelector('.sotb-admin-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });

    form.querySelectorAll('input[type="file"]').forEach(function (input) {
      input.addEventListener('change', function () {
        var preview = modal.querySelector('.sotb-admin-preview[data-field="' + input.name + '"]');
        if (!preview || !input.files[0]) return;
        preview.src = URL.createObjectURL(input.files[0]);
        preview.hidden = false;
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!currentPanel) return;

      var endpoint = currentPanel.getAttribute('data-endpoint');
      var isEdit = !!form.elements.id.value;
      var formData = new FormData(form);
      formData.set('token', config.token);
      formData.set('action', isEdit ? 'update' : 'create');
      // Checkboxes only submit a value when checked; force explicit 0/1.
      formData.set('abilita', form.elements.abilita.checked ? '1' : '0');
      formData.set('in_evidenza', form.elements.in_evidenza.checked ? '1' : '0');

      fetch(config.apiBase + endpoint, { method: 'POST', body: formData })
        .then(function (res) {
          return res.json();
        })
        .then(function (json) {
          if (json.status === 'ok') {
            showNotice(currentPanel, 'Salvato.');
            loadList(currentPanel);
            closeModal();
          } else {
            showNotice(currentPanel, json.error || 'Errore nel salvataggio.', true);
          }
        })
        .catch(function () {
          showNotice(currentPanel, 'Errore nel salvataggio.', true);
        });
    });
  }

  /* ============================================================
     TABS + INIT
     ============================================================ */
  var panels = document.querySelectorAll('.sotb-admin-tab-panel');
  var tabs = document.querySelectorAll('.sotb-admin-tabs .nav-tab');

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function (e) {
      e.preventDefault();
      var target = tab.getAttribute('data-tab');
      tabs.forEach(function (t) {
        t.classList.toggle('nav-tab-active', t === tab);
      });
      panels.forEach(function (panel) {
        panel.hidden = panel.id !== 'sotb-tab-' + target;
      });
    });
  });

  panels.forEach(function (panel) {
    panel.querySelector('.sotb-add-new').addEventListener('click', function () {
      openModal(panel, null);
    });
    loadList(panel);
  });
})();
