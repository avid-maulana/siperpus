<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* =========================================================
           SWEET ALERT
        ========================================================== */

        function loadSweetAlert(callback) {

            if (window.Swal) {
                callback();
                return;
            }

            const script = document.createElement('script');

            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';

            script.onload = callback;

            script.onerror = function () {
                console.error('SweetAlert2 gagal dimuat.');
            };

            document.head.appendChild(script);
        }


        /* =========================================================
           HELPER ANIMATION
        ========================================================== */

        function showElement(element) {

            if (!element) return;

            element.classList.remove('edit-hidden');

            void element.offsetWidth;

            element.classList.add('edit-visible');
        }


        function hideElement(element) {

            if (!element) return;

            element.classList.remove('edit-visible');

            element.classList.add('edit-hidden');
        }


        /* =========================================================
           EDIT TIPE
        ========================================================== */

        window.openTypeEdit = function (id) {

            const row =
                document.getElementById('type-row-' + id);

            const display =
                document.getElementById('type-display-' + id);

            const form =
                document.getElementById('type-form-' + id);

            const normalActions =
                document.getElementById(
                    'type-normal-actions-' + id
                );

            const editActions =
                document.getElementById(
                    'type-edit-actions-' + id
                );


            if (!row || !form) return;


            row.classList.add('editing');

            hideElement(display);
            showElement(form);


            if (normalActions) {
                normalActions.classList.add('hidden');
            }

            if (editActions) {
                editActions.classList.remove('hidden');
                editActions.classList.add('flex');
            }


            const input = form.querySelector('input');


            if (input) {

                setTimeout(function () {

                    input.focus();
                    input.select();

                }, 120);

            }

        };


        /* =========================================================
           BATAL TIPE
        ========================================================== */

        window.cancelTypeEdit = function (id) {

            const row =
                document.getElementById('type-row-' + id);

            const display =
                document.getElementById('type-display-' + id);

            const form =
                document.getElementById('type-form-' + id);

            const normalActions =
                document.getElementById(
                    'type-normal-actions-' + id
                );

            const editActions =
                document.getElementById(
                    'type-edit-actions-' + id
                );


            if (!row || !form) return;


            row.classList.remove('editing');

            hideElement(form);
            showElement(display);


            if (normalActions) {
                normalActions.classList.remove('hidden');
            }

            if (editActions) {
                editActions.classList.add('hidden');
                editActions.classList.remove('flex');
            }

        };


        /* =========================================================
           SIMPAN TIPE
        ========================================================== */

        window.submitTypeEdit = function (id) {

            const form =
                document.getElementById('type-form-' + id);

            if (!form) return;


            const input =
                form.querySelector('input');

            if (!input) return;


            if (input.value.trim() === '') {

                input.focus();

                return;
            }


            form.submit();

        };


        /* =========================================================
           EDIT KATEGORI
        ========================================================== */

        window.openCategoryEdit = function (id) {

            const row =
                document.getElementById(
                    'category-row-' + id
                );

            const nameDisplay =
                document.getElementById(
                    'category-name-display-' + id
                );

            const nameEdit =
                document.getElementById(
                    'category-name-edit-' + id
                );

            const typeDisplay =
                document.getElementById(
                    'category-type-display-' + id
                );

            const typeEdit =
                document.getElementById(
                    'category-type-edit-' + id
                );

            const normalActions =
                document.getElementById(
                    'category-normal-actions-' + id
                );

            const editActions =
                document.getElementById(
                    'category-edit-actions-' + id
                );


            if (!row) return;


            row.classList.add('editing');


            hideElement(nameDisplay);
            showElement(nameEdit);

            hideElement(typeDisplay);
            showElement(typeEdit);


            if (normalActions) {
                normalActions.classList.add('hidden');
            }

            if (editActions) {
                editActions.classList.remove('hidden');
                editActions.classList.add('flex');
            }


            const input =
                document.getElementById(
                    'category-input-' + id
                );


            if (input) {

                setTimeout(function () {

                    input.focus();
                    input.select();

                }, 120);

            }

        };


        /* =========================================================
           BATAL KATEGORI
        ========================================================== */

        window.cancelCategoryEdit = function (id) {

            const row =
                document.getElementById(
                    'category-row-' + id
                );

            const nameDisplay =
                document.getElementById(
                    'category-name-display-' + id
                );

            const nameEdit =
                document.getElementById(
                    'category-name-edit-' + id
                );

            const typeDisplay =
                document.getElementById(
                    'category-type-display-' + id
                );

            const typeEdit =
                document.getElementById(
                    'category-type-edit-' + id
                );

            const normalActions =
                document.getElementById(
                    'category-normal-actions-' + id
                );

            const editActions =
                document.getElementById(
                    'category-edit-actions-' + id
                );


            if (!row) return;


            row.classList.remove('editing');


            hideElement(nameEdit);
            showElement(nameDisplay);

            hideElement(typeEdit);
            showElement(typeDisplay);


            if (normalActions) {
                normalActions.classList.remove('hidden');
            }

            if (editActions) {
                editActions.classList.add('hidden');
                editActions.classList.remove('flex');
            }

        };


        /* =========================================================
           SIMPAN KATEGORI
        ========================================================== */

        window.submitCategoryEdit = function (id) {

            const form =
                document.getElementById(
                    'category-form-' + id
                );

            if (!form) return;


            const input =
                document.querySelector(
                    '#category-input-' + id
                );

            const select =
                document.querySelector(
                    '#category-type-edit-' + id + ' select'
                );


            if (!input || !select) return;


            if (input.value.trim() === '') {

                input.focus();

                return;
            }


            if (select.value === '') {

                select.focus();

                return;
            }


            form.submit();

        };


        /* =========================================================
           DELETE CONFIRMATION
        ========================================================== */

        function initDeleteConfirm() {

            const deleteForms =
                document.querySelectorAll('.delete-form');


            if (!deleteForms.length) {
                return;
            }


            deleteForms.forEach(function (form) {

                if (form.dataset.confirmBound === 'true') {
                    return;
                }


                form.dataset.confirmBound = 'true';


                form.addEventListener('submit', function (e) {

                    e.preventDefault();


                    const itemName =
                        form.dataset.itemName || 'data ini';


                    loadSweetAlert(function () {

                        Swal.fire({

                            icon: 'warning',

                            title: 'Hapus ' + itemName + '?',

                            html: `
                                <div style="
                                    text-align: left;
                                    margin-top: 12px;
                                ">

                                    <div style="
                                        padding: 12px 14px;
                                        border-radius: 10px;
                                        background: #fef2f2;
                                        border: 1px solid #fecaca;
                                        color: #991b1b;
                                        font-size: 13px;
                                        line-height: 1.5;
                                        margin-bottom: 16px;
                                    ">

                                        <strong>Perhatian!</strong><br>

                                        Penghapusan data dapat berdampak
                                        pada data yang memiliki hubungan
                                        dengan data ini.

                                    </div>


                                    <label style="
                                        display: flex;
                                        align-items: flex-start;
                                        gap: 10px;
                                        cursor: pointer;
                                        font-size: 13px;
                                        color: #475569;
                                    ">

                                        <input
                                            type="checkbox"
                                            id="delete-confirm-checkbox"
                                            style="
                                                width: 17px;
                                                height: 17px;
                                                margin-top: 1px;
                                                flex-shrink: 0;
                                                cursor: pointer;
                                            "
                                        >

                                        <span>
                                            Saya memahami bahwa penghapusan
                                            data ini dapat menghapus data
                                            yang terkait.
                                        </span>

                                    </label>

                                </div>
                            `,

                            showCancelButton: true,

                            confirmButtonText: 'Ya, Hapus',

                            cancelButtonText: 'Batal',

                            confirmButtonColor: '#dc2626',

                            cancelButtonColor: '#64748b',

                            reverseButtons: true,

                            focusCancel: true,

                            background: '#ffffff',

                            borderRadius: '16px',

                            allowOutsideClick: false,

                            allowEscapeKey: true,

                            didOpen: function () {

                                const checkbox =
                                    document.getElementById(
                                        'delete-confirm-checkbox'
                                    );

                                const confirmButton =
                                    Swal.getConfirmButton();


                                /*
                                 * Tombol hapus awalnya disabled.
                                 */

                                confirmButton.disabled = true;

                                confirmButton.style.opacity = '0.5';

                                confirmButton.style.cursor = 'not-allowed';


                                /*
                                 * Aktifkan setelah checkbox dicentang.
                                 */

                                checkbox.addEventListener(
                                    'change',
                                    function () {

                                        confirmButton.disabled =
                                            !checkbox.checked;


                                        if (checkbox.checked) {

                                            confirmButton.style.opacity = '1';

                                            confirmButton.style.cursor =
                                                'pointer';

                                        } else {

                                            confirmButton.style.opacity = '0.5';

                                            confirmButton.style.cursor =
                                                'not-allowed';

                                        }

                                    }
                                );

                            }

                        }).then(function (result) {

                            if (result.isConfirmed) {

                                form.submit();

                            }

                        });

                    });

                });

            });

        }


        /* =========================================================
           ENTER = SIMPAN
        ========================================================== */

        document.addEventListener('keydown', function (e) {

            if (e.key !== 'Enter') {
                return;
            }


            const target = e.target;


            /* TYPE */

            if (
                target.matches(
                    '#type-form-\\d+ input'
                )
            ) {

                const form =
                    target.closest('form');


                if (form) {

                    e.preventDefault();

                    form.submit();

                }

            }


            /* CATEGORY */

            if (
                target.matches(
                    '#category-input-\\d+'
                )
            ) {

                const formId =
                    target.getAttribute('form');


                const form =
                    document.getElementById(formId);


                if (form) {

                    e.preventDefault();

                    form.submit();

                }

            }

        });


        /* =========================================================
           INITIALIZE
        ========================================================== */

        initDeleteConfirm();


        window.initDeleteConfirm =
            initDeleteConfirm;

    });
</script>