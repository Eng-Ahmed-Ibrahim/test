<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>رفع فيديو - Chunked Upload</title>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1/resumable.js"></script>
</head>
<body>
    <h1>رفع فيديو (Chunked Upload) مع Resumable.js</h1>

    <div id="upload-container">
        <button id="browseButton">اختر ملف الفيديو</button>
        <div id="progress" style="margin-top: 20px;"></div>
    </div>

<script>
    
document.addEventListener('DOMContentLoaded', function () {
    // إعداد resumable.js
    var r = new Resumable({
        target: '{{ route("video.upload") }}', // رابط رفع الملف في الباك اند
        query: {_token: '{{ csrf_token() }}'}, // توكين حماية CSRF
        chunkSize: 1 * 1024 * 1024, // حجم القطعة: 1 ميجابايت
        simultaneousUploads: 3, // عدد القطع المرفوعة في نفس الوقت
        testChunks: true, // اختبار هل القطعة مرفوعة مسبقًا
        throttleProgressCallbacks: 1
    });

    r.assignBrowse(document.getElementById('browseButton'));

    r.on('fileAdded', function(file) {
        document.getElementById('progress').innerHTML = 'بدأ رفع الملف: ' + file.fileName;
        r.upload();
    });

    r.on('fileProgress', function(file) {
        var progress = Math.floor(r.progress() * 100);
        document.getElementById('progress').innerHTML = 'رفع ' + file.fileName + ': ' + progress + '%';
    });

    r.on('fileSuccess', function(file, response) {
        document.getElementById('progress').innerHTML = 'تم رفع الفيديو بنجاح!';
        console.log(response);
        // هنا ممكن تعرض إشعار أو شيء آخر
    });

    r.on('fileError', function(file, message) {
        document.getElementById('progress').innerHTML = 'حدث خطأ أثناء الرفع: ' + message;
    });
});
</script>
</body>
</html>
