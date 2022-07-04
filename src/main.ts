import Main from './DevTools.svelte';

const target = document.getElementById('jetpack-inspect');
const app = new Main({target});

export default app;