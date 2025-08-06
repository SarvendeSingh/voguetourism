        </main> <!-- End main content -->
    </div> <!-- End row -->
</div> <!-- End container-fluid -->

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- CKEditor 5 Rich Text Editor Script (Free and Open Source) -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Select all textareas with the 'wysiwyg' class
        const editors = document.querySelectorAll('textarea.wysiwyg');
        
        // Loop through each textarea and initialize CKEditor
        editors.forEach(editor => {
            ClassicEditor
                .create(editor, {
                    // Configuration for the editor
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'link', 'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    },
                    language: 'en',
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells'
                        ]
                    },
                    licenseKey: '', // No license key required for the open-source version
                })
                .catch(error => {
                    console.error('There was a problem initializing the editor:', error);
                });
        });
    });
</script>

</body>
</html>