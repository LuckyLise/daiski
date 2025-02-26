
 
 <!-- Bootstrap JavaScript Libraries -->
 <script
     src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
     integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
     crossorigin="anonymous"></script>

 <script
     src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
     integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
     crossorigin="anonymous"></script>
     
  <script src="https://code.jquery.com/jquery-3.7.103b .min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 

<!-- 刪除課程用 -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function() {
            let courseId = this.getAttribute("data-course-id");
            if (confirm("確定要刪除這個課程嗎？此操作無法復原！")) {
                window.location.href = "delete_course.php?id=" + courseId;
            }
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".delete-photo-btn").forEach(function(btn) {
        btn.addEventListener("click", function(){
            var photoId = this.getAttribute("data-photo-id");
            if (confirm("確定要刪除這張照片嗎？")) {
                fetch("delete_course_image.php?photo_id=" + photoId)
                .then(response => response.text())
                .then(data => {
                    if(data.trim() === "success"){
                        // 刪除成功，移除這個照片區塊
                        this.parentElement.remove();
                    } else {
                        alert("刪除失敗！");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("刪除失敗！");
                });
            }
        });
    });
});
</script>

<script src="./js/bootstrap.bundle.min.js?time=<?=time();?>"></script>
<script src="./js/jquery.min.js?time=<?=time();?>"></script>

<script src="./js/sb-admin-2.js?time=<?=time();?>"></script>