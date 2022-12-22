
export let editor=null;

export function create_editor() {
    editor=sceditor.create(document.getElementById('editor'), {
        format: 'bbcode',
        width: '100%',
        height: '300px',
        icons: 'monocons',
        style: '/css/default.min.css',
        locale: 'fr-FR'
    });
}
