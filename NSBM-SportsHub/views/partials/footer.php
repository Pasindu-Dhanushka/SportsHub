<?php use App\Core\Auth; ?>
<?php if (Auth::check()): ?>
        </section>
        <footer class="app-footer"><span>© <?= date('Y') ?> NSBM SportsHub</span><span>Built for Web & Mobile Application Development</span></footer>
    </main>
</div>
<?php else: ?>
</main>
<footer class="public-footer">
    <div class="footer-brand brand"><span class="brand-mark"><i class="bi bi-lightning-charge-fill"></i></span><span><strong>SportsHub</strong><small>Train. Compete. Belong.</small></span></div>
    <p>One home for NSBM sports clubs, fixtures, tournaments and student participation.</p>
    <small>© <?= date('Y') ?> NSBM SportsHub · Student project</small>
</footer>
<?php endif; ?>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
