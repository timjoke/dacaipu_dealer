<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>Excel导入</span>
                    </h2>  
    </div>
    
    <div class ="ContArea" style="margin-top:50px;margin-left: 50px;">
        <p style="margin-bottom: 20px;font-size: 18px;"><a href="http://img1.dacaipu.cn\pc\dish.xlsx">Excel模板下载</a></p>
        <form action="/dish/uploadExcel" method="post"
              enctype="multipart/form-data">
            <label for="file">Excel文件:</label>
            <input type="file" name="file" id="file" /> 
            <br />
            <input type="submit" name="submit" class="BatchBtn" value="导入" style="width:100px;"/>
        </form>
    </div>
    
        <?php
        if(isset($error_mes))
        {
            
            if($error_mes == "0")
            {
                echo '<div style="height:50px;margin-top:50px;margin-left:50px;border:1px solid red;
         color:red;vertical-align: middle;text-align: center;font-size:20px;">导入成功！</div>';
            }
            else if($error_mes == "-1")
            {
                echo '<div style="height:50px;margin-top:50px;margin-left:50px;border:1px solid red;
         color:red;vertical-align: middle;text-align: center;font-size:20px;">文件错误！</div>';
            }else if($error_mes == "4")
            {
                echo '<div style="height:50px;margin-top:50px;margin-left:50px;border:1px solid red;
         color:red;vertical-align: middle;text-align: center;font-size:20px;">请选择文件！</div>';
            }
            else
            {
                echo '<div style="height:50px;margin-top:50px;margin-left:50px;border:1px solid red;
         color:red;vertical-align: middle;text-align: center;font-size:20px;">'.$error_mes.'</div>';
            }
        }
        ?>
    
</div>
