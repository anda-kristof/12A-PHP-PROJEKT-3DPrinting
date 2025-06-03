<?php 

?>

<style>
body {
    min-height: 100vh;
    margin: 0;
    background: linear-gradient(120deg, #232526 0%, #414345 100%);
    font-family: 'Segoe UI', Arial, sans-serif;
    overflow-x: hidden;
}

.login-register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90vh;
}

.dual-card {
    display: flex;
    width: 650px;
    height: 370px;
    box-shadow: 0 8px 40px 0 rgba(0,0,0,0.18);
    border-radius: 32px;
    background: rgba(255,255,255,0.07);
    overflow: hidden;
    position: relative;
}

.dual-side {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: flex 0.6s cubic-bezier(.68,-0.55,.27,1.55), background 0.5s;
    cursor: pointer;
    position: relative;
    z-index: 1;
    background: rgba(255,255,255,0.13);
}

.dual-side .btn {
    font-size: 1.5rem;
    font-weight: 600;
    padding: 18px 40px;
    border-radius: 32px;
    border: none;
    transition: background 0.3s, color 0.3s, transform 0.4s cubic-bezier(.68,-0.55,.27,1.55);
    box-shadow: 0 4px 24px 0 rgba(0,0,0,0.14);
    margin-top: 32px;
    background: rgba(255,255,255,0.12);
    color: #232526;
}

.dual-side h2 {
    color: #fff;
    letter-spacing: 1px;
    text-shadow: 0 3px 20px rgba(0,0,0,0.25);
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 12px;
}

.dual-side p {
    color: #e0e0e0;
    font-size: 1.05rem;
    margin: 0 28px;
    text-align: center;
}

.dual-side.left {
    border-top-left-radius: 32px;
    border-bottom-left-radius: 32px;
}

.dual-side.right {
    border-top-right-radius: 32px;
    border-bottom-right-radius: 32px;
}

.dual-side:not(:hover) {
    z-index: 1;
}


.dual-side:hover {
    flex: 1.35;
    background: linear-gradient(120deg,rgb(81, 255, 17) 0%,rgb(7, 90, 2) 100%);
    z-index: 2;
    box-shadow: 0 4px 40px 0 rgba(252,182,159,0.25);
}

.dual-side:hover h2,
.dual-side:hover p {
    color: #232526;
    text-shadow: none;
}

.dual-side:hover .btn {
    background: #232526;
    color: #fff;
    transform: scale(1.09);
}


@media (max-width: 800px) {
    .dual-card {
        flex-direction: column;
        width: 90vw;
        height: 540px;
        min-width: 0;
    }
    .dual-side {
        border-radius: 0 !important;
    }
    .dual-side.left {
        border-top-left-radius: 32px;
        border-top-right-radius: 32px;
        border-bottom-left-radius: 0;
    }
    .dual-side.right {
        border-bottom-left-radius: 32px;
        border-bottom-right-radius: 32px;
        border-top-right-radius: 0;
    }
}
</style>

<div class="login-register-container">
    <div class="dual-card">
        <div class="dual-side left" onclick="window.location='?todo=login'">
            <h2>Bejelentkezés</h2>
            <p>Már van fiókod? Jelentkezz be, és kezdd el a 3D nyomtatást!</p>
            <button class="btn">Bejelentkezés</button>
        </div>
        <div class="dual-side right" onclick="window.location='?todo=registration'">
            <h2>Regisztráció</h2>
            <p>Nincs még fiókod? Csatlakozz hozzánk, és fedezd fel a 3D nyomtatás világát!</p>
            <button class="btn">Regisztráció</button>
        </div>
    </div>
</div>