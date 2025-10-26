<!-- BEGIN: MAIN -->
<div class="loginotp container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient text-secondary text-center py-4" style="background: linear-gradient(135deg, #5a67d8, #764ba2);">
                    <h2 class="mb-0 fw-bold">{LOGINOTP_TITLE}</h2>
                </div>

                <div class="card-body p-4 p-md-5">

                    <!-- IF {LOGINOTP_ERROR} -->
                    <div
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>{LOGINOTP_ERROR}</div>
                    </div>
                    <!-- ELSE -->
                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>{LOGINOTP_ENTER_CODE}</div>
                    </div>
                    <!-- ENDIF -->

                    <form method="post" action="{LOGINOTP_FORM_ACTION}" class="needs-validation" novalidate>
                        <input type="hidden" name="user" value="{LOGINOTP_USER_ID}">
                        <!-- IF {LOGINOTP_REDIRECT} -->
                        <input type="hidden" name="redirect" value="{LOGINOTP_REDIRECT}">
                        <!-- ENDIF -->

                        <div class="mb-4">
                            <label for="code" class="form-label fw-semibold">{LOGINOTP_CODE_LABEL}</label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg text-center otp-input" 
                                id="code" 
                                name="code" 
                                maxlength="5" 
                                pattern="[0-9]{5}" 
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                required 
                                placeholder="_____"
                                style="letter-spacing: 0.5rem; font-size: 1.5rem; font-weight: bold;">
                            <div class="form-text text-muted small mt-2">
                                {LOGINOTP_HINT}
                            </div>
                            <div class="invalid-feedback text-center">
                                {LOGINOTP_INVALID_CODE}
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm">
                            {LOGINOTP_SUBMIT}
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            {LOGINOTP_LIFETIME}
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="bi-info-circle-fill" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
    </symbol>
    <symbol id="bi-exclamation-triangle-fill" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>

<style>
    .otp-input::placeholder {
        color: #adb5bd;
        letter-spacing: 0.5rem;
    }
    .card { border-radius: 1rem; }
    .btn-primary {
        background: linear-gradient(135deg, #5a67d8, #764ba2);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(90, 103, 216, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.needs-validation');
        const input = document.getElementById('code');
        input.focus(); input.select();

        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault(); e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
<!-- END: MAIN -->