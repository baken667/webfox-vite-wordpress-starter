import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";
import * as path from 'path'

export default defineConfig({
    plugins: [
        liveReload(__dirname + '/**/*.php'),
    ],
    root: '',
    base: process.env.NODE_ENV === 'development' ? '/' : '/dist/',
    build: {
        outDir: path.resolve(__dirname, './dist/'),
        emptyOutDir: true,
        manifest: true,
        target: 'es2018',
        rollupOptions: {
            input: {
                main: path.resolve(__dirname, 'main.js'),
            }
        },
        minify: true,
        write: true
    },
    server: {
        cors: true,
        strictPort: true,
        port: 3000,
        https: false,
        hmr: {
            host: 'localhost'
        }
    },
    resolve: {
        alias: {}
    }
})