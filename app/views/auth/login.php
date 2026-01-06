<div class="login-wrapper">
    <div class="login-box">
        <h2>Login to SAMS</h2>

        <?php if(!empty($error)): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</div>
