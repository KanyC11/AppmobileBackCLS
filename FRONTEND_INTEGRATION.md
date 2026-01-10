# Guide Frontend - Intégration API Mobile Citizen SN

## Table des matières
1. [Vue d'ensemble](#vue-densemble)
2. [Configuration de base](#configuration-de-base)
3. [Intégration des formulaires](#intégration-des-formulaires)
4. [Exemples pratiques](#exemples-pratiques)
5. [Gestion des erreurs](#gestion-des-erreurs)
6. [Upload de fichiers](#upload-de-fichiers)
7. [Bonnes pratiques](#bonnes-pratiques)

---

## Vue d'ensemble

L'API Mobile Citizen SN est une API REST accessible via `http://localhost:8000/api/` (développement) ou votre domaine de production.

**Base URL (développement):** `http://127.0.0.1:8000`
**Base URL (production):** À configurer selon votre serveur

Tous les endpoints acceptent JSON en réponse et certains acceptent `multipart/form-data` pour les uploads de fichiers.

---

## Configuration de base

### 1. URL de base

Créez une constante ou variable pour votre base URL :

```javascript
// config.js ou au début de votre app
const API_BASE_URL = 'http://127.0.0.1:8000/api';
```

Pour la production, chargez depuis une variable d'environnement :

```javascript
const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';
```

### 2. Fonction générique de fetch

Créez une fonction réutilisable pour les appels API :

```javascript
async function apiCall(endpoint, options = {}) {
  const url = `${API_BASE_URL}${endpoint}`;
  const defaultOptions = {
    headers: {
      'Content-Type': 'application/json',
      ...options.headers,
    },
  };

  // Pour multipart/form-data, ne pas définir Content-Type
  // Le navigateur le fera automatiquement
  if (options.body instanceof FormData) {
    delete defaultOptions.headers['Content-Type'];
  }

  const response = await fetch(url, {
    ...defaultOptions,
    ...options,
  });

  if (!response.ok) {
    const error = await response.text();
    throw new Error(`API Error ${response.status}: ${error}`);
  }

  return response.json();
}
```

---

## Intégration des formulaires

### ⚠️ RÈGLE IMPORTANTE

**N'ajoutez JAMAIS d'attribut `action` sur vos formulaires.**

❌ **À NE PAS FAIRE:**
```html
<form action="http://localhost:8000/api/membres" method="post">
  <!-- Ne pas faire ceci! -->
</form>
```

✅ **À FAIRE:**
```html
<form onsubmit="handleFormSubmit(event, '/api/membres')" method="post">
  <!-- Gérer la soumission en JavaScript -->
</form>
```

### Fonction de gestion des formulaires

```javascript
async function handleFormSubmit(event, endpoint) {
  event.preventDefault(); // CRUCIAL - Empêche la soumission par défaut
  
  const form = event.target;
  const submitButton = form.querySelector('button[type="submit"]');
  
  // Désactiver le bouton pendant la soumission
  submitButton.disabled = true;
  const originalText = submitButton.textContent;
  submitButton.textContent = 'En cours...';

  try {
    const formData = new FormData(form);
    const method = form.querySelector('input[name="_method"]')?.value || 'POST';
    
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      method: method.toUpperCase(),
      body: formData,
      // NE PAS AJOUTER Content-Type ici - FormData le gère
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Erreur serveur');
    }

    const data = await response.json();
    
    // Réinitialiser le formulaire
    form.reset();
    
    // Afficher un message de succès
    alert(`Succès! Status: ${response.status}`);
    
    // Vous pouvez aussi retourner les données
    return data;
    
  } catch (error) {
    alert(`Erreur: ${error.message}`);
    console.error('Détails:', error);
  } finally {
    // Réactiver le bouton
    submitButton.disabled = false;
    submitButton.textContent = originalText;
  }
}
```

---

## Exemples pratiques

### Exemple 1: Créer une catégorie (formulaire simple)

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/categories')" method="post">
  <label>
    Libellé
    <input type="text" name="libelle" required>
  </label>
  <button type="submit">Créer catégorie</button>
</form>
```

**JavaScript:**
```javascript
// Utiliser la fonction générique handleFormSubmit ci-dessus
```

**Réponse API (201):**
```json
{
  "id": 9,
  "libelle": "Nouvelle Catégorie",
  "created_at": "2026-01-10T14:30:00Z",
  "updated_at": "2026-01-10T14:30:00Z"
}
```

---

### Exemple 2: Créer un membre

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/membres')" method="post">
  <div>
    <label>
      Prénom
      <input type="text" name="prenom" required>
    </label>
    <label>
      Nom
      <input type="text" name="nom" required>
    </label>
  </div>
  <div>
    <label>
      Email
      <input type="email" name="email" required>
    </label>
    <label>
      Téléphone
      <input type="tel" name="telephone">
    </label>
  </div>
  <div>
    <label>
      Fonction
      <input type="text" name="fonction" required>
    </label>
    <label>
      Structure/Entreprise
      <input type="text" name="structure" required>
    </label>
  </div>
  <label>
    Sexe
    <select name="sexe">
      <option value="">-- Choisir --</option>
      <option value="M">Homme</option>
      <option value="F">Femme</option>
    </select>
  </label>
  <button type="submit">Créer membre</button>
</form>
```

---

### Exemple 3: Upload de document

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/documents')" method="post" enctype="multipart/form-data">
  <label>
    Libellé (titre)
    <input type="text" name="libelle" required>
  </label>
  
  <label>
    Description
    <textarea name="description" rows="4"></textarea>
  </label>
  
  <label>
    Catégorie
    <select name="categorie_id" required>
      <option value="">-- Choisir une catégorie --</option>
      <option value="1">Tech</option>
      <option value="2">Formation</option>
      <option value="3">Civic Tech</option>
      <!-- ... autres catégories -->
    </select>
  </label>
  
  <label>
    Fichier (PDF, Word, Excel, etc.)
    <input type="file" name="fichier" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" required>
  </label>
  
  <button type="submit">Uploader document</button>
</form>
```

**Points importants:**
- `enctype="multipart/form-data"` — **obligatoire** pour les uploads
- Le champ file doit s'appeler `fichier`
- Fichiers acceptés: PDF, DOC, DOCX, XLS, XLSX, TXT, ZIP (max 10MB)
- Ne pas ajouter `action` au formulaire

---

### Exemple 4: Upload d'audio (Podcast)

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/podcasts')" method="post" enctype="multipart/form-data">
  <label>
    Titre de l'épisode
    <input type="text" name="libelle" required>
  </label>
  
  <label>
    Description
    <textarea name="description" rows="4"></textarea>
  </label>
  
  <label>
    Membre (auteur)
    <select name="membre_id" required>
      <option value="">-- Choisir un membre --</option>
      <option value="1">Jean Dupont</option>
      <option value="2">Awa Diop</option>
      <!-- Charger dynamiquement depuis /api/membres -->
    </select>
  </label>
  
  <label>
    Catégorie
    <select name="categorie_id" required>
      <option value="1">Tech</option>
      <option value="2">Formation</option>
      <!-- ... -->
    </select>
  </label>
  
  <label>
    Fichier audio (MP3, WAV, M4A, FLAC, AAC)
    <input type="file" name="fichier" accept="audio/*" required>
  </label>
  
  <button type="submit">Uploader podcast</button>
</form>
```

**Formats acceptés:** MP3, WAV, M4A, FLAC, AAC (max 50MB)

---

### Exemple 5: Créer un événement avec image

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/evenements')" method="post" enctype="multipart/form-data">
  <label>
    Nom de l'événement
    <input type="text" name="libelle" required>
  </label>
  
  <label>
    Description
    <textarea name="description" rows="4" required></textarea>
  </label>
  
  <div class="date-fields">
    <label>
      Date de début
      <input type="date" name="date_debut" required>
    </label>
    <label>
      Date de fin
      <input type="date" name="date_fin" required>
    </label>
  </div>
  
  <div class="time-fields">
    <label>
      Heure de début (HH:mm)
      <input type="time" name="heure_debut" required>
    </label>
    <label>
      Heure de fin (HH:mm)
      <input type="time" name="heure_fin" required>
    </label>
  </div>
  
  <label>
    Type (Conférence, Atelier, Webinaire, etc.)
    <input type="text" name="type" required>
  </label>
  
  <label>
    Lieu
    <input type="text" name="lieu">
  </label>
  
  <label>
    Lien (Zoom, Google Meet, etc.)
    <input type="url" name="lien">
  </label>
  
  <label>
    Image (JPG, PNG, GIF - max 5MB)
    <input type="file" name="image" accept="image/*">
  </label>
  
  <button type="submit">Créer événement</button>
</form>
```

---

### Exemple 6: Mettre à jour un enregistrement

Pour mettre à jour, utilisez le champ caché `_method` avec la valeur `PUT` :

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/membres/5')" method="post">
  <input type="hidden" name="_method" value="PUT">
  
  <label>
    Prénom
    <input type="text" name="prenom">
  </label>
  
  <label>
    Nom
    <input type="text" name="nom">
  </label>
  
  <label>
    Email
    <input type="email" name="email">
  </label>
  
  <button type="submit">Mettre à jour</button>
</form>
```

---

### Exemple 7: Supprimer un enregistrement

**HTML:**
```html
<form onsubmit="handleFormSubmit(event, '/api/membres/5')" method="post">
  <input type="hidden" name="_method" value="DELETE">
  <p>Êtes-vous sûr de vouloir supprimer ce membre?</p>
  <button type="submit">Supprimer</button>
</form>
```

---

## Gestion des erreurs

### Erreur 422 - Données invalides

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "libelle": ["The libelle field is required."],
    "fichier": ["The fichier must be a file of type: pdf, doc, docx."]
  }
}
```

**Solution:**
```javascript
async function handleFormSubmit(event, endpoint) {
  event.preventDefault();
  
  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      method: 'POST',
      body: new FormData(event.target),
    });

    if (!response.ok) {
      const errorData = await response.json();
      
      // Afficher les erreurs de validation
      if (errorData.errors) {
        let errorMessage = 'Erreurs de validation:\n';
        Object.entries(errorData.errors).forEach(([field, messages]) => {
          errorMessage += `${field}: ${messages.join(', ')}\n`;
        });
        alert(errorMessage);
      } else {
        alert(errorData.message);
      }
      return;
    }

    alert('Succès!');
  } catch (error) {
    alert(`Erreur réseau: ${error.message}`);
  }
}
```

### Erreur 404 - Ressource non trouvée

```json
{"message": "No query results for model [App\\Models\\Membre] 6"}
```

Vérifiez que l'ID existe avant de faire un PUT ou DELETE.

### Erreur 500 - Erreur serveur

Vérifiez les logs du serveur : `storage/logs/laravel.log`

---

## Upload de fichiers

### Principes clés

1. **Utilisez `FormData`** pour les uploads
2. **Ajoutez `enctype="multipart/form-data"`** au formulaire
3. **Ne définissez PAS `Content-Type`** manuellement — le navigateur le fait
4. **Respectez les limites** de taille et type

### Exemple complet avec validation

```javascript
async function handleFileUpload(event, endpoint) {
  event.preventDefault();
  
  const form = event.target;
  const fileInput = form.querySelector('input[type="file"]');
  const file = fileInput.files[0];
  
  // Validation côté client
  const maxSize = 10 * 1024 * 1024; // 10MB
  if (file.size > maxSize) {
    alert(`Le fichier est trop volumineux (max ${maxSize / 1024 / 1024}MB)`);
    return;
  }
  
  // Soumettre
  const formData = new FormData(form);
  
  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      method: 'POST',
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`Erreur ${response.status}`);
    }

    const data = await response.json();
    alert(`Fichier uploadé avec succès! ID: ${data.id}`);
    form.reset();
  } catch (error) {
    alert(`Erreur lors de l'upload: ${error.message}`);
  }
}
```

---

## Bonnes pratiques

### 1. Always use `event.preventDefault()`

```javascript
async function handleFormSubmit(event, endpoint) {
  event.preventDefault(); // ← TOUJOURS faire ceci en premier
  // ...
}
```

### 2. Ne pas utiliser d'attribut `action`

```html
<!-- ❌ MAUVAIS -->
<form action="/api/membres" onsubmit="handleSubmit(event)">

<!-- ✅ BON -->
<form onsubmit="handleSubmit(event, '/api/membres')">
```

### 3. Désactiver le bouton pendant la soumission

```javascript
const btn = form.querySelector('button[type="submit"]');
btn.disabled = true;
try {
  // fetch...
} finally {
  btn.disabled = false;
}
```

### 4. Gérer les champs optionnels

Certains champs peuvent être optionnels. Vérifiez la documentation API.

```javascript
// Pour documents: libelle, description, categorie_id, fichier (requis)
// Pour podcasts: libelle, description, membre_id, categorie_id, fichier (requis)
// Pour événements: image, lien (optionnels)
```

### 5. Loader les listes dynamiquement

```javascript
async function loadCategories() {
  try {
    const response = await fetch(`${API_BASE_URL}/categories`);
    const categories = await response.json();
    
    const select = document.querySelector('select[name="categorie_id"]');
    categories.forEach(cat => {
      const option = document.createElement('option');
      option.value = cat.id;
      option.textContent = cat.libelle;
      select.appendChild(option);
    });
  } catch (error) {
    console.error('Erreur lors du chargement des catégories:', error);
  }
}

// Appeler au chargement de la page
document.addEventListener('DOMContentLoaded', loadCategories);
```

### 6. Afficher un loader pendant les requêtes

```javascript
async function handleFormSubmit(event, endpoint) {
  event.preventDefault();
  
  const form = event.target;
  const loader = document.createElement('div');
  loader.textContent = 'Chargement...';
  loader.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 20px; border-radius: 8px; z-index: 9999;';
  document.body.appendChild(loader);

  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      method: 'POST',
      body: new FormData(form),
    });

    // ...
  } finally {
    loader.remove();
  }
}
```

### 7. Gérer les réponses JSON correctement

```javascript
const response = await fetch(url, options);

// Toujours vérifier le status
if (!response.ok) {
  const error = await response.json();
  throw new Error(error.message || 'Erreur inconnue');
}

// Puis parser le JSON
const data = await response.json();
```

---

## Framework-spécifique

### React (Hooks)

```jsx
import { useState } from 'react';

export function CreateMember() {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleSubmit = async (event) => {
    event.preventDefault();
    setLoading(true);
    setError(null);

    const formData = new FormData(event.target);

    try {
      const response = await fetch('http://127.0.0.1:8000/api/membres', {
        method: 'POST',
        body: formData,
      });

      if (!response.ok) {
        throw new Error('Erreur lors de la création');
      }

      const data = await response.json();
      alert(`Membre créé: ${data.prenom} ${data.nom}`);
      event.target.reset();
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={(e) => handleSubmit(e)}>
      <input type="text" name="prenom" required placeholder="Prénom" />
      <input type="text" name="nom" required placeholder="Nom" />
      <button type="submit" disabled={loading}>
        {loading ? 'En cours...' : 'Créer'}
      </button>
      {error && <p style={{ color: 'red' }}>{error}</p>}
    </form>
  );
}
```

### Vue.js

```vue
<template>
  <form @submit.prevent="handleSubmit">
    <input v-model="form.prenom" type="text" placeholder="Prénom" required />
    <input v-model="form.nom" type="text" placeholder="Nom" required />
    <button type="submit" :disabled="loading">
      {{ loading ? 'En cours...' : 'Créer' }}
    </button>
    <p v-if="error" style="color: red">{{ error }}</p>
  </form>
</template>

<script>
export default {
  data() {
    return {
      form: { prenom: '', nom: '' },
      loading: false,
      error: null,
    };
  },
  methods: {
    async handleSubmit() {
      this.loading = true;
      this.error = null;

      const formData = new FormData();
      formData.append('prenom', this.form.prenom);
      formData.append('nom', this.form.nom);

      try {
        const response = await fetch('http://127.0.0.1:8000/api/membres', {
          method: 'POST',
          body: formData,
        });

        if (!response.ok) throw new Error('Erreur serveur');

        const data = await response.json();
        alert(`Membre créé: ${data.prenom} ${data.nom}`);
        this.form = { prenom: '', nom: '' };
      } catch (err) {
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
```

---

## Checklist d'intégration

- [ ] Configuration de `API_BASE_URL`
- [ ] Fonction générique `handleFormSubmit` implémentée
- [ ] Tous les formulaires utilisent `onsubmit` (pas d'`action`)
- [ ] `event.preventDefault()` appelé au début
- [ ] Bouton de soumission désactivé pendant la requête
- [ ] Gestion des erreurs 422 et autres codes d'erreur
- [ ] Upload de fichiers avec `FormData` et `enctype="multipart/form-data"`
- [ ] Listes dynamiques chargées depuis l'API
- [ ] Messages de succès/erreur affichés à l'utilisateur
- [ ] Tests avec Network tab (F12) pour vérifier une seule requête par soumission

---

## Support

Pour des questions :
1. Vérifier la [documentation API complète](./API_DOCUMENTATION.md)
2. Consulter les logs du serveur : `storage/logs/laravel.log`
3. Ouvrir Network tab dans DevTools (F12) pour inspecter les requêtes

---

**Dernière mise à jour:** 10 janvier 2026
