const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

// Set output folder for production ready assets
mix.setPublicPath('public/build/prod');

/**
 * Recursive helper to find files in directories zero-dependency
 */
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

// 1. Compile App JS and CSS (Tailwind CSS v4)
mix.js('resources/js/app.js', 'js')
   .postCss('resources/css/app.css', 'css', [
       require('@tailwindcss/postcss'),
   ]);

// 2. DYNAMICALLY Compile all JS files in public/js recursively, preserving folder structure
getFiles('public/js', [], '.js').forEach(file => {
    const relativeDir = path.dirname(path.relative('public/js', file));
    const outputDir = path.join('js', relativeDir).replace(/\\/g, '/');
    mix.js(file, outputDir);
});

// 3. DYNAMICALLY Compile all CSS files in public/css recursively, preserving folder structure
getFiles('public/css', [], '.css').forEach(file => {
    const relativeDir = path.dirname(path.relative('public/css', file));
    const outputDir = path.join('css', relativeDir).replace(/\\/g, '/');
    mix.postCss(file, outputDir);
});
