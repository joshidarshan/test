# Developer Guide: Coding & Testing Workflow

This guide details the complete workflow and list of commands for coding, compiling, and testing assets inside the **`public/css/`** and **`public/js/`** folders of your application using Laravel Mix.

---

## 1. Quick Setup & Environment

We have configured the application to boot using **`.env.live`** instead of `.env` automatically across all HTTP requests and Artisan console commands.

### Environment Management Commands
* **Clear Config Cache**: Always run this if you edit `.env.live` variables so the app registers them instantly:
  ```bash
  php artisan config:clear
  ```
* **Verify Active Environment**:
  ```bash
  php artisan env
  ```

---

## 2. All Developer Commands

Run these terminal commands from your project root directory. 

> [!NOTE]
> On Windows, if you encounter PowerShell execution restrictions, prefix your NPM commands with `cmd /c` (e.g., `cmd /c npm run watch`).

| Command | Purpose |
| :--- | :--- |
| **`npm run watch`** | **Development Mode**: Starts the auto-compiler. Automatically detects code changes and compiles them instantly in the background. |
| **`npm run build`** | **Production Mode**: Overwrites compiled files with minified CSS and minified/uglified JavaScript, optimizing them for production. |
| **`php artisan serve`** | **Local Server**: Starts the local development web server (default: `http://127.0.0.1:8000`). |
| **`php artisan view:clear`** | **Flush Cache**: Clears cached Blade views to force-refresh changes on pages. |

---

## 3. Real-Time Coding & Testing Flow

Follow this workflow to code and see your changes load instantly in your browser:

### Step 1: Start the Watcher & Server
Open your terminal and boot up the asset auto-compiler:
```bash
npm run watch
```
*(Keep this terminal window running in the background).*

In a second terminal window, start your local server:
```bash
php artisan serve
```

---

### Step 2: Edit Your Files Directly
All source styles and scripts are managed inside the `public/` directories. Open any of these files in your IDE and make edits:
* **Dashboard Page**:
  - CSS: `public/css/dashboard.css`
  - JS: `public/js/dashboard.js`
* **Login Page**:
  - CSS: `public/css/login.css`
  - JS: `public/js/login.js`
* **About Us Page**:
  - CSS: `public/css/about.css`
  - JS: `public/js/about.js`
* **Contact Us Page**:
  - CSS: `public/css/contact.css`
  - JS: `public/js/contact.js`

---

### Step 3: Save and Refresh
1. Save your changes (**Ctrl + S**).
2. The watcher terminal will automatically compile the files in milliseconds:
   `✔ Compiled Successfully`
3. Refresh your browser page (e.g., `http://127.0.0.1:8000/dashboard`) to view your new changes live!

---

## 4. How Production Build (Uglification) Works

When you run **`npm run build`**, Laravel Mix processes the files from `public/css/` and `public/js/` and compiles them into **`public/build/prod/`**:

1. **Uglification**: Removes line breaks, comments, whitespace, and renames variables to single letters (`t`, `e`, `a`) to minimize file size.
2. **Minification**: Squeezes CSS rules onto a single line and optimizes colors and themes.
3. **Asset Delivery**: Blade templates load assets from this folder using the custom global helper:
   ```html
   <link rel="stylesheet" href="{{ global_asset('build/prod/css/dashboard.css') }}">
   <script src="{{ global_asset('build/prod/js/dashboard.js') }}"></script>
   ```

---

## 4. Summary of Project Files & Code Changes

Here is a list of all files that were newly created or modified, along with the key code changes.

### 📁 Config & System Modifications

#### 1. [webpack.mix.js](file:///l:/Project/Production/myproject/webpack.mix.js) (Created)
Configured Laravel Mix (Webpack) to compile CSS and JS recursively and dynamically from the `public/css` and `public/js` folders, automatically preserving subfolders (e.g. `public/css/list/`, `public/css/table/`):
```javascript
const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

mix.setPublicPath('public/build/prod');

// Recursive helper to scan directories
function getFiles(dir, fileList = [], ext = '.js') {
    if (!fs.existsSync(dir)) return fileList;
    fs.readdirSync(dir).forEach(file => {
        const filePath = path.join(dir, file);
        if (fs.statSync(filePath).isDirectory()) {
            getFiles(filePath, fileList, ext);
        } else if (path.extname(file) === ext) {
            fileList.push(filePath);
        }
    });
    return fileList;
}

// 1. Compile App JS/CSS
mix.js('resources/js/app.js', 'js')
   .postCss('resources/css/app.css', 'css', [
       require('@tailwindcss/postcss'),
   ]);

// 2. DYNAMICALLY Compile all JS files recursively, preserving directory structure
getFiles('public/js', [], '.js').forEach(file => {
    const relativeDir = path.dirname(path.relative('public/js', file));
    const outputDir = path.join('js', relativeDir).replace(/\\/g, '/');
    mix.js(file, outputDir);
});

// 3. DYNAMICALLY Compile all CSS files recursively, preserving directory structure
getFiles('public/css', [], '.css').forEach(file => {
    const relativeDir = path.dirname(path.relative('public/css', file));
    const outputDir = path.join('css', relativeDir).replace(/\\/g, '/');
    mix.postCss(file, outputDir);
});
```

#### 2. [package.json](file:///l:/Project/Production/myproject/package.json) (Modified)
- Removed `"type": "module"` to support Webpack CommonJS `require()`.
- Replaced `vite` build/dev commands with `mix` scripts.
- Installed `@tailwindcss/postcss` and `postcss` to compile Tailwind CSS v4 in Mix.
- Downgraded `webpack` to `^5.74.0` and `webpack-cli` to `^4.10.0` to solve version incompatibilities:
```json
  "scripts": {
      "dev": "npm run development",
      "development": "mix",
      "watch": "mix watch",
      "watch-poll": "mix watch -- --watch-options-poll=1000",
      "hot": "mix watch --hot",
      "prod": "npm run production",
      "production": "mix --production",
      "build": "npm run production"
  }
```

#### 3. [bootstrap/app.php](file:///l:/Project/Production/myproject/bootstrap/app.php) (Modified)
Instructed Laravel to read configs from `.env.live` instead of `.env`:
```php
$app->loadEnvironmentFrom('.env.live');
```

#### 4. [app/Providers/AppServiceProvider.php](file:///l:/Project/Production/myproject/app/Providers/AppServiceProvider.php) (Modified)
Registered a global namespace helper function `global_asset()` inside `namespace { ... }` so it maps to `asset()`:
```php
namespace {
    if (!function_exists('global_asset')) {
        function global_asset($path, $secure = null) {
            return asset($path, $secure);
        }
    }
}
```

#### 5. [routes/web.php](file:///l:/Project/Production/myproject/routes/web.php) (Modified)
Added routes for `/dashboard`, `/about`, and `/contact`:
```php
Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
```

#### 6. [composer.json](file:///l:/Project/Production/myproject/composer.json) (Modified)
Renamed concurrently dev command tag name from `vite` to `mix`.

---

### 🖥️ Newly Created Blade Views

* **[login.blade.php](file:///l:/Project/Production/myproject/resources/views/login.blade.php)**: Renders a premium, glassmorphic login screen pre-filled for a secure session, linking to the compiled production assets:
  ```html
  <link rel="stylesheet" href="{{ global_asset('build/prod/css/login.css') }}">
  <script src="{{ global_asset('build/prod/js/login.js') }}"></script>
  ```
* **[dashboard.blade.php](file:///l:/Project/Production/myproject/resources/views/dashboard.blade.php)**: Custom workspace showing interactive counts of visitor, server, and security stats for **Darshan Joshi**.
* **[about.blade.php](file:///l:/Project/Production/myproject/resources/views/about.blade.php)**: Renders values, roadmap, and statements for PortalHub.
* **[contact.blade.php](file:///l:/Project/Production/myproject/resources/views/contact.blade.php)**: Glassmorphic interactive mail/contact form, validating inputs and shaking fields on error.

---

## 5. Live Production Server Deployment Steps

Follow these exact steps when deploying your project to a live production server.

### Step 1: Set Up the Live Environment File (`.env`)
On a live production server, you want the environment variables loaded from the standard `.env` file.
1. **Rename/Copy the File**:
   Copy or move `.env.live` as `.env`:
   ```bash
   cp .env.live .env
   # Or on Windows PowerShell:
   Copy-Item .env.live .env
   ```
2. **Restore Bootstrap Loader**:
   Open [bootstrap/app.php](file:///l:/Project/Production/myproject/bootstrap/app.php). Comment out or remove the line that forces `.env.live` so that Laravel goes back to its default behavior of reading the standard `.env` file:
   ```php
   // Remove or comment out this line:
   // $app->loadEnvironmentFrom('.env.live');
   ```

---

### Step 2: Compile Production Ready Assets
Run the production Webpack compiler from your project root. This minifies the CSS and minifies/uglifies the JS directly into `public/build/prod/`:
```bash
npm run build
```
*(On Windows, if needed: `cmd /c npm run build`)*

---

### Step 3: Run Production Performance Caching
To maximize application performance on the live server, compile and cache all configurations, routes, and views:
1. **Cache Configurations**:
   ```bash
   php artisan config:cache
   ```
2. **Cache Routes**:
   ```bash
   php artisan route:cache
   ```
3. **Pre-compile Views**:
   ```bash
   php artisan view:cache
   ```

---

### Step 4: Verification Check List
* [ ] Verify that `.env` is loaded by running `php artisan env` (Output: `The application environment is [production]`).
* [ ] Open your live URL (e.g. `https://yourdomain.com/dashboard`) and check that CSS & JS are fully uglified and minified.
* [ ] Check that `public/build/prod/mix-manifest.json` exists and maps all production routes.

---

## 6. How We Removed Vite & Configured Laravel Mix

For educational and maintenance purposes, here is the exact step-by-step history of how we migrated from Vite to Laravel Mix:

### 1. Stripped Out Vite Configurations
* **Deleted `vite.config.js`**: Completely removed the configuration file from the project root.
* **Removed Vite Dependencies**: Removed the `@tailwindcss/vite` and `laravel-vite-plugin` packages from the dependencies.

### 2. Transitioned to CommonJS & Setup Mix
* **Removed `"type": "module"` in `package.json`**: By default, fresh Laravel setups force ES modules (`"type": "module"`) for Vite. We removed this line so Webpack and Laravel Mix can safely parse `webpack.mix.js` using Node's standard CommonJS `require()` commands.
* **Created `webpack.mix.js`**: Initialized and configured the Webpack compilation pipeline, utilizing native Node recursively to scan subdirectories.

### 3. Solved Version Mismatches (Webpack SizeFormatHelpers Error)
* **The Problem**: Webpack ^5.80+ removed or relocated `SizeFormatHelpers`, causing Laravel Mix 6 to break during compilation with the error `Cannot find module 'webpack/lib/SizeFormatHelpers'`.
* **The Solution**: We force-downgraded the `webpack` dependency in the lockfile to `^5.74.0` and `webpack-cli` to `^4.10.0` by running:
  ```bash
  npm install webpack@5.74.0 webpack-cli@4.10.0 --save-dev
  ```
  This locked down the dependency versions and allowed Mix to compile with 100% stability.

### 4. Configured Tailwind CSS v4 to Compile in Mix
* **The Problem**: Tailwind CSS v4 relies heavily on Vite compilation triggers.
* **The Solution**: We uninstalled `@tailwindcss/vite`, installed **`@tailwindcss/postcss`** and **`postcss`** inside our `package.json` devDependencies, and ran the stylesheet through Mix's `postCss()` plugin:
  ```javascript
  mix.postCss('resources/css/app.css', 'css', [
      require('@tailwindcss/postcss'),
  ]);
  ```

### 5. Swapped Blade Assets Directives
* **Home Page View (`welcome.blade.php`)**: Replaced the `@vite` array injection directive with the standard `mix()` helper.
* **Custom Pages Views (`login`, `dashboard`, etc.)**: Pointed asset loading tags directly to compiled assets in the production directory using the `global_asset()` helper inside double curly-braces:
  ```html
  <link rel="stylesheet" href="{{ global_asset('build/prod/css/login.css') }}">
  ```

---

## 7. Quick Reference: All Commands Cheat Sheet

Here is a consolidated, complete cheat sheet of every terminal command used in this project's development and production lifecycle.

### 🛠️ 1. Asset Compilation (Webpack / Mix)

* **Start Development Auto-Compiler (Watcher)**:
  ```bash
  npm run watch
  # Windows CMD/PowerShell fallback:
  cmd /c npm run watch
  ```
* **Compile production-ready, minified and uglified assets**:
  ```bash
  npm run build
  # Windows CMD/PowerShell fallback:
  cmd /c npm run build
  ```
* **Run standard development build (one-time)**:
  ```bash
  npm run dev
  # Windows CMD/PowerShell fallback:
  cmd /c npm run dev
  ```

---

### 🌐 2. Local Environment & Development Server

* **Start the Local Development Web Server**:
  ```bash
  php artisan serve
  ```
* **Verify active booted environment (e.g. local or production)**:
  ```bash
  php artisan env
  ```

---

### ⚡ 3. Performance Caching & Cache Flushing

* **Production Server Caching (Run on deployment)**:
  ```bash
  # Cache all configurations, routes, and views in one go:
  php artisan optimize
  ```
* **Clear all cached items (Run during debugging)**:
  ```bash
  # Clear configurations, routes, and views cache:
  php artisan optimize:clear
  ```
* **Individual Cache Clearing Commands**:
  - **Flush Blade Views Cache**: `php artisan view:clear`
  - **Flush Configuration Cache**: `php artisan config:clear`
  - **Flush Routes Cache**: `php artisan route:clear`
* **Individual Caching Commands**:
  - **Pre-compile all Blade Views**: `php artisan view:cache`
  - **Cache Configuration Variables**: `php artisan config:cache`
  - **Cache Route Declarations**: `php artisan route:cache`

---

### 📦 4. Dependency Setup & Version Resolution

* **Install all Node Packages (NPM dependencies)**:
  ```bash
  npm install
  # Windows CMD/PowerShell fallback:
  cmd /c npm install
  ```
* **Force Lock/Downgrade Webpack to resolve SizeFormatHelpers compilation errors**:
  ```bash
  npm install webpack@5.74.0 webpack-cli@4.10.0 --save-dev
  # Windows CMD/PowerShell fallback:
  cmd /c npm install webpack@5.74.0 webpack-cli@4.10.0 --save-dev
  ```





            "npx concurrently -c \"#93c5fd,#c4b5fd,#fb7185,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1 --timeout=0\" \"php artisan pail --timeout=0\" \"npm run dev\" --names=server,queue,logs,mix --kill-others