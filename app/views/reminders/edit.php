<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Edit Note
                    </h3>
                </div>
                <div class="card-body">
                    <form action="/reminders/update/<?php echo $data['reminder']['id']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="subject" 
                                   name="subject" 
                                   value="<?php echo htmlspecialchars($data['reminder']['subject']); ?>"
                                   placeholder="Enter note subject"
                                   required 
                                   maxlength="255">
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" 
                                      id="content" 
                                      name="content" 
                                      rows="6" 
                                      placeholder="Enter your note content here..."><?php echo htmlspecialchars($data['reminder']['content'] ?? ''); ?></textarea>
                            <div class="form-text">Optional: Add detailed content for your note.</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="completed" 
                                       name="completed" 
                                       <?php echo $data['reminder']['completed'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="completed">
                                    Mark as completed
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">
                                    Created: 
                                    <?php 
                                    $createdAt = $data['reminder']['created_at'] ?? null;
                                    if ($createdAt) {
                                        echo date('M j, Y g:i A', strtotime($createdAt));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <span class="badge <?php echo $data['reminder']['completed'] ? 'bg-success' : 'bg-warning'; ?>">
                                    <?php echo $data['reminder']['completed'] ? 'Completed' : 'Pending'; ?>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="/reminders/delete/<?php echo $data['reminder']['id']; ?>" 
                               class="btn btn-outline-danger"
                               onclick="return confirm('Are you sure you want to delete this note?')">
                                <i class="fas fa-trash"></i> Delete Note
                            </a>
                            <div>
                                <a href="/reminders" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Note
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-resize textarea
document.getElementById('content').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

window.addEventListener('load', function() {
    const content = document.getElementById('content');
    content.style.height = 'auto';
    content.style.height = content.scrollHeight + 'px';
});
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
