<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus-circle"></i> Create New Note
                    </h3>
                </div>
                <div class="card-body">
                    <form action="/reminders/store" method="POST">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="subject" 
                                   name="subject" 
                                   placeholder="Enter note subject"
                                   required 
                                   maxlength="255">
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" 
                                      id="content" 
                                      name="content" 
                                      rows="6" 
                                      placeholder="Enter your note content here..."></textarea>
                            <div class="form-text">Optional: Add detailed content for your note.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/reminders" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.getElementById('content').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
