<?php
// views/settings/index.php
// Settings page mimicking dashboard style
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Settings
            <small>Manage your preferences</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Preferences</h3>
                    </div>
                    <form id="settingsForm" method="post" action="<?php echo base_url('Controller_Settings/update'); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="mode">Mode</label>
                                <select class="form-control" id="mode" name="mode">
                                    <option value="light" <?php echo (isset($settings['mode']) && $settings['mode'] == 'light') ? 'selected' : ''; ?>>Light</option>
                                    <option value="dark" <?php echo (isset($settings['mode']) && $settings['mode'] == 'dark') ? 'selected' : ''; ?>>Dark</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="language">Language</label>
                                <select class="form-control" id="language" name="language">
                                    <option value="english" <?php echo (isset($settings['language']) && $settings['language'] == 'english') ? 'selected' : ''; ?>>English</option>
                                    <option value="amharic" <?php echo (isset($settings['language']) && $settings['language'] == 'amharic') ? 'selected' : ''; ?>>Amharic</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="calendar">Calendar</label>
                                <select class="form-control" id="calendar" name="calendar">
                                    <option value="european" <?php echo (isset($settings['calendar']) && $settings['calendar'] == 'european') ? 'selected' : ''; ?>>European</option>
                                    <option value="ethiopian" <?php echo (isset($settings['calendar']) && $settings['calendar'] == 'ethiopian') ? 'selected' : ''; ?>>Ethiopian</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
// Simple dark/light mode toggle (frontend only)
document.getElementById('mode').addEventListener('change', function() {
    if (this.value === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
});
</script>
<style>
.dark-mode {
    background-color: #222 !important;
    color: #eee !important;
}
</style>
