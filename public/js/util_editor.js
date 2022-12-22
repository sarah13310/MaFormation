
export function create_editor() {
    sceditor.create(document.getElementById('editor'), {
        format: 'bbcode',
        width: '100%',
        height: '330px',
        icons: 'monocons',
        style: '<?= $base ?>/css/default.min.css',
        locale: 'fr-FR'
    });
}
