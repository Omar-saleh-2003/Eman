<?php
// تحديد المنطقة الزمنية لتوقيت مصر
date_default_timezone_set('Africa/Cairo');

// التأكد من أن الطلب هو POST وأن الرسالة ليست فارغة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {

    // تنظيف الرسالة من أي أكواد ضارة بسيطة
    $message = htmlspecialchars(trim($_POST['message']));
    
    // تحديد اسم الملف الذي سيتم الحفظ فيه
    $filename = 'messages.txt';
    
    // الحصول على الوقت والتاريخ الحالي
    $timestamp = date('Y-m-d h:i:s A');
    
    // تنسيق الرسالة مع الوقت والتاريخ
    $entry = "-------------------------\n";
    $entry .= "Time: " . $timestamp . "\n";
    $entry .= "Message: " . $message . "\n";
    $entry .= "-------------------------\n\n";

    // كتابة الرسالة في نهاية الملف مع ضمان عدم التداخل
    if (file_put_contents($filename, $entry, FILE_APPEND | LOCK_EX)) {
        // إرسال رد نجاح بصيغة JSON
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    } else {
        // إرسال رد خطأ في حالة فشل الحفظ
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Could not write to file.']);
    }
} else {
    // إرسال رد خطأ إذا كان الطلب غير صحيح
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
