
<div class="registration-wrapper">
    <div class="registration-card">
        <h1>Regisztráció</h1>
        <form method="POST" action="?todo=signup" autocomplete="off">
            <div class="mb-4">
                <label for="username" class="form-label">Felhasználónév</label>
                <input type="text" name="username" id="username" class="form-control reg-input"
                       value='<?php if(isset($username)) echo htmlspecialchars($username);?>' autocomplete="off">
                <?php if(isset($errors['username'])): ?>
                    <div class="form-error"><?php echo $errors['username']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email cím</label>
                <input type="email" name="email" id="email" class="form-control reg-input"
                       value='<?php if(isset($email)) echo htmlspecialchars($email);?>' autocomplete="off">
                <?php if(isset($errors['email'])): ?>
                    <div class="form-error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" name="password" id="password" class="form-control reg-input" autocomplete="off">
                <?php if(isset($errors['password'])): ?>
                    <div class="form-error"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="repassword" class="form-label">Jelszó Újra</label>
                <input type="password" name="repassword" id="repassword" class="form-control reg-input" autocomplete="off">
                <?php if(isset($errors['repassword'])): ?>
                    <div class="form-error"><?php echo $errors['repassword']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-4 text-center">
                <button type="submit" class="reg-btn">Regisztráció</button>
            </div>
        </form>
    </div>
</div>

<style>
body {
    background: linear-gradient(120deg, #181d23 0%, #232b33 100%);
    font-family: 'Segoe UI', Arial, sans-serif;
    min-height: 100vh;
    margin: 0;
}
.form-error {
    color: #ff5252;
    font-size: 0.97rem;
    margin-top: 4px;
    margin-left: 4px;
    font-weight: 500;
    letter-spacing: .2px;
}
input.reg-input, input.reg-input:focus, input.reg-input:active {
    color: #d3f9e8 !important;
    background: #222730;
}

.registration-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
}

.registration-card {
    background: rgba(25, 30, 37, 0.95);
    box-shadow: 0 8px 40px 0 rgba(0,0,0,0.25);
    border-radius: 24px;
    padding: 48px 34px 36px 34px;
    max-width: 410px;
    width: 100%;
    animation: fadeInUp 0.9s cubic-bezier(.85,-0.25,.22,1.2);
    position: relative;
    overflow: hidden;
}

.registration-card:before {
    content: "";
    position: absolute;
    left: -60px;
    top: -60px;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, #1ed760 50%, transparent 80%);
    filter: blur(18px);
    opacity: 0.35;
    z-index: 0;
    pointer-events: none;
}

.registration-card:after {
    content: "";
    position: absolute;
    right: -50px;
    bottom: -50px;
    width: 110px;
    height: 110px;
    background: radial-gradient(circle, #0df2a9 60%, transparent 90%);
    filter: blur(10px);
    opacity: 0.22;
    z-index: 0;
    pointer-events: none;
}

.registration-card h1 {
    text-align: center;
    color: #1ed760;
    margin-bottom: 30px;
    font-weight: 700;
    letter-spacing: 1px;
    font-size: 2.1rem;
    z-index: 1;
    position: relative;
    text-shadow: 0 2px 16px #1ed76022, 0 1px 0 #222;
}

.form-label {
    color: #d6fad9;
    font-size: 1.02rem;
    margin-bottom: 6px;
    z-index: 1;
    position: relative;
    letter-spacing: .5px;
}

.reg-input {
    background: #222730;
    border: 1.5px solid #1ed76033;
    border-radius: 8px;
    color: #d3f9e8;
    font-size: 1.1rem;
    padding: 12px 14px;
    transition: border 0.2s, box-shadow 0.2s;
    outline: none;
    z-index: 1;
    position: relative;
}

.reg-input:focus {
    border-color: #1ed760;
    box-shadow: 0 0 0 2px #1ed76044;
    background: #21262c;
}

.reg-btn {
    background: linear-gradient(90deg, #1ed760 30%, #0df2a9 100%);
    color: #232b33;
    font-weight: 700;
    font-size: 1.08rem;
    border: none;
    border-radius: 18px;
    padding: 13px 42px;
    box-shadow: 0 3px 14px 0 #1ed76044;
    letter-spacing: 1px;
    cursor: pointer;
    transition: background 0.22s, transform 0.16s, color 0.22s, box-shadow 0.21s;
    z-index: 1;
    position: relative;
}

.reg-btn:hover, .reg-btn:active {
    background: linear-gradient(90deg, #13b455 30%, #0df2a9 100%);
    color: #fff;
    transform: translateY(-2px) scale(1.035);
    box-shadow: 0 6px 24px 0 #1ed76055;
}

.mb-4 {
    margin-bottom: 1.45rem !important;
}
.text-center {
    text-align: center;
}

/* Subtle input glow on hover */
.reg-input:hover {
    border-color: #0df2a9cc;
    background: #232b33;
}

/* Nice fade-in animation */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(60px);
    }
    100% {
        opacity: 1;
        transform: none;
    }
}

/* Responsive */
@media (max-width: 600px) {
    .registration-card {
        padding: 24px 8vw 18px 8vw;
        max-width: 95vw;
    }
    .registration-card h1 {
        font-size: 1.3rem;
    }
}
</style>