<h1>FileAPP.php</h1>
    <span>FileAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/File/php/FileAPP.php</span>
    <span>Namespace: system\module\File\php</span>
    <span>Instance: new \system\module\File\php\FileAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>
    <span>FileAPP extends the File class from the same namespace.</span>
    
    <h2>Functions</h2>
        <h3>FileAPP->accept</h3>
            <span>Returns array with allowed filetypes for upload with the FileAPP module</span>
            <span>Allowed filetypes are set up in /system/ini/accept.ini file.</span>
            <ul>
                <li>
                    <h4>FileAPP->accept()</h4>
                    <p>Example: $FileAPP->accept()</p>
                    <span>Will return array with all allowed filetypes for upload.</span>
                </li>
            </ul>
            
        <h3>FileAPP->files_dir</h3>
            <span>Returns path to file location by id</span>
            <ul>
                <li>
                    <h4>FileAPP->files_dir(id, link_id)</h4>
                    <p>Example: $FileAPP->files_dir(4)</p>
                    <span>Will return the path of the file with id 4.</span>
                    <span>Example output: web/file/4</span>
                </li>
            </ul>
        
        <h3>FileAPP->delete_dir</h3>
            <span>Delete directory path recursively</span>
            <ul>
                <li>
                    <h4>FileAPP->delete_dir(path).</h4>
                    <p>Example: $FileAPP->delete_dir("/web/directory/delete").</p>
                    <span>Will recursively delete all files and folders in /web/directory/delete.</span>
                </li>
            </ul>
            
        <h3>FileAPP->copy_dir</h3>
            <span>Copy directory path to another location recursively</span>
            <ul>
                <li>
                    <h4>FileAPP->copy_dir(source, destination).</h4>
                    <p>Example: $FileAPP->copy_dir("/web/copy", "/web/new").</p>
                    <span>Will recursively copy all files and folders in /web/copy to /web/new.</span>
                </li>
            </ul>
        
        <h3>FileAPP->unique_file_name</h3>
            <span>Return unique file name for given name and path.</span>
            <span>If the given name is already unique, returns the same.</span>
            <ul>
                <li>
                    <h4>FileAPP->unique_file_name(directory, name).</h4>
                    <p>Example: $FileAPP->unique_file_name("/web/copy", "myname.jpg").</p>
                    <span>Will return unique filename for directory /web/copy based on filename - myname.jpg.</span>
                    <span>Example output: myname.jpg, myname(1).jpg, myname(2).jpg ... </span>
                </li>
            </ul>
            
        <h3>FileAPP->input_form</h3>
            <span>This private function is part of FileAPP->input.</span>
            
        <h3>FileAPP->input</h3>
            <span>Form input automated function to upload files to the system.</span>
            <span>It supports single and multiple attachments modes.</span>
            <span>Must be included in method="post" and enctype="multipart/form-data" forms to work.</span>
            <ul>
                <li>
                    <h4>FileAPP->input(name, array=array()).</h4>
                    <span>name: the name of the file input form field.</span>
                    <span>array:</span>
                        <ul>
                            <li>multiple (boolean): set true to enable multiple files upload mode.</li>
                            <li>link_id (integer): set link_id of the file/files for upload.</li>
                            <li>accept (array): set allowed filetypes to upload. If not set, the module allowed filetypes from the FileAPP->accept function will be set.</li>
                            <li>tag (string): enable text input field to add tag to the file/files and fill it with the passed value.</li>
                            <li>languages (boolean): set to true to enable alt tags input fields for all system enabled languages.</li>
                        </ul>
                    <p>Example: $FileAPP->input("favicon").</p>
                    <span>Will add file input widget for single file to the form.</span>
                    <p>Example: $FileAPP->input("favicon", array("multiple" => "true", "languages" => true, "accept" => "image/x-png,image/gif,image/jpeg", "link_id" => 4, "tag" => "Favicon")).</p>
                    <span>Will add file input widget for multiple files to the form. The alt tag in all languages will be available for every file. Tag label will be enabled too. Files will take link_id =4 and only image types - png and jpeg will be allowed for insert.</span>
                </li>
            </ul>
            
        <h3>FileAPP->upload</h3>
            <span>Upload all files posted by FileAPP->input function</span>
            <span>Creates files directories and inserts database records in File module table automatically</span>
            <span>Creates downsized images based on the File->imagesize resolutions for responsive layouts. This functionality requires GD library module enabled in your PHP installation. If GD library is missing, this action is omitted.</span>
            <ul>
                <li>
                    <h4>FileAPP->upload(array=array()).</h4>
                    <span>array (this settings are optional and are not needed for file uploads. They are available for more customization options though):</span>
                        <ul>
                            <li>page_id (integer): set page_id for all posted files. If not set default is File->page_id or if gallery files are posted, page_id is set to gallery id record.</li>
                            <li>link_id (integer): set link_id for all posted files. If not set default is 0 or if gallery files are posted, link_id is set to parent gallery category.</li>
                            <li>tag (string): set tag for all posted files. If not set default is NULL or if tag is posted for the concrete file upload, tag is set to the posted value.</li>
                            <li>path (string): set upload location for all posted files. If not set default is File->files_dir.</li>
                            <li>accept (array): set allowed upload filetypes. If not set default is File->accept_ini.</li>
                        </ul>
                    <p>Example: $FileAPP->upload().</p>
                    <span>Will upload all allowed by File->accept_ini posted files from FileAPP->input function to the File->files_dir folder. If filetypes are images (jpg, png) and GD library is installed it will create resized images with File->imagesize sized also.</span>
                    <p>Example: $FileAPP->upload("page_id" => 4, "link_id" => 2, "tag" => "Favicon"), "path" => "web/custom-files", "accept" => "image/x-png").</p>
                    <span>Will upload all files with type png in web/custom-files directory. The files will have page_id=4, link_id=2 and tag=Favicon. It will also create downsized images if GD library is installed with File->imagesize size, because allowed filetype to upload is png.</span>
                </li>
            </ul>
            
        <h3>FileAPP->input_edit</h3>
            <span>File input edit in form for a single file</span>
            <span>Multiple usage of this function in single form is possible for</span>
            <ul>
                <li>
                    <h4>FileAPP->input_edit(file, array=array()).</h4>
                    <span>File: selected row from File->table with all parameters ($PDO->query("SELECT * FROM " . $File->table. " WHERE...")->fetch() for example).</span>
                    <span>array:</span>
                        <ul>
                            <li>page_id (boolean): Enable select dropdown setting with all pages from Page->table to choose page_id for the file.</li>
                            <li>tag (boolean): enable text input field to edit tag of the file.</li>
                            <li>path (boolean): enable text input field to edit path of the file.</li>
                            <li>languages (boolean): enable text input fields to edit languages fileds of the file.</li>
                            <li>accept (array): set allowed filetypes to edit. If not set, the module allowed filetypes from the FileAPP->accept function will be set.</li>
                            <li>type (boolean): enable text input field to edit type of the file.</li>
                            <li>full (boolean): set to true to enable all file edit options.</li>
                        </ul>
                    <p>Example: $FileAPP->input_edit($file_selected).</p>
                    <span>Will add file edit widget for single file to the form. Only name option of the file will be available for edit.</span>
                    <p>Example: $FileAPP->input_edit($file_selected, array("page_id" => true, "tag" => true, "languages" => true)).</p>
                    <span>Will add file edit widget for single file to the form. Name, page_id, tag and languages options of the file will be available for edit.</span>
                    <p>Example: $FileAPP->input_edit($file_selected, array("full" => true)).</p>
                    <span>Will add file edit widget for single file to the form. All possible options of the file will be available for edit.</span>
                </li>
            </ul>
            
            <h3>FileAPP->upload_edit</h3>
            <span>Edit all files posted by FileAPP->edit function</span>
            <span>Replace files and update database records in File module table automatically</span>
            <span>Creates downsized images based on the File->imagesize resolutions for responsive layouts for the replaced images. This functionality requires GD library module enabled in your PHP installation. If GD library is missing, this action is omitted.</span>
            <ul>
                <li>
                    <h4>FileAPP->upload_edit(array=array()).</h4>
                    <span>array (this settings are optional and are not needed for file edits. They are available for more customization options though):</span>
                        <ul>
                            <li>path (string): set upload location for all posted files. If not set default is File->files_dir.</li>
                            <li>accept (array): set allowed upload filetypes. If not set default is File->accept_ini.</li>
                        </ul>
                    <p>Example: $FileAPP->upload_edit().</p>
                    <span>Will replace all allowed by File->accept_ini posted files from FileAPP->input_edit functions to the File->files_dir folder. It will also edit all posted options in the database for the files.  If filetypes are images (jpg, png) and GD library is installed it will create resized images with File->imagesize sized also.</span>
                    <p>Example: $FileAPP->upload_edit("path" => "web/custom-files", "accept" => "image/x-png").</p>
                    <span>Will replace all files with type png in web/custom-files directory posted by FileAPP->input_edit functions. It will also create downsized images if GD library is installed with File->imagesize size, because allowed filetype to upload is png.</span>
                </li>
            </ul>
            
            <h3>FileAPP->make_thumbnail (private function)</h3>
            <span>Creates downsized copies of uploaded images with FileAPP->upload and FileAPP->upload_edit functions.</span>
            <span>Supports jpg and png image types only</span>
            <span>Resolutions are set in File->imagesize.</span>
            <span>New downsized files are created only for imagesizes, that are lower from the original uploaded images resolutions.</span>
            <ul>
                <li>
                    <h4>FileAPP->make_thumbnail(file, new_name, max_width = false, max_height = false). Important: at least one of the max_width or max_height option should be set.</h4>
                    <span>file (post file object): the file to be uploaded form file input form field (for example: $_FILES["example_file"]).</span>
                    <span>new_name (string): the new name of the resized file.</span>
                    <span>max_width (integer): set maximum allowed resize width. This setting is optional and if set to false the function will make automatic calculations for the new image width based on the passed max_height value.</span>
                    <span>max_height (integer): set maximum allowed resize height. This setting is optional and if set to false the function will make automatic calculations for the new image height based on the passed max_width value.</span>
                    <p>Example: $FileAPP->make_thumbnail($_FILES["example_file"], "/web/file/24/exapmle_file_M.png", 1280).</p>
                    <span>Will make thumbnail of the posted example_file from form with name /web/file/24/exapmle_file_M.png. The new image width will be 1280 pixels and the new image height will be automaticaly calculated to keep up the proportions of the image.</span>
                </li>
            </ul>
            
            <h3>FileAPP->upload_file (private function)</h3>
            <span>Upload files posted from FileAPP->upload and FileAPP->upload_edit functions.</span>
            <span>New downsized files are created with FileAPP->make_thumbnail function only if posted files are images.</span>
            <ul>
                <li>
                    <h4>FileAPP->upload_file(array=array())</h4>
                    <span>array:</span>
                        <ul>
                            <li>name (string): the name of the file to upload.</li>
                            <li>path (string): the location to upload file in.</li>
                            <li>error (string): the $_FILE["example_file"]["error"].</li>
                            <li>type (string): the $_FILE["example_file"]["type"].</li>
                            <li>tmp_name (string): the $_FILE["example_file"]["tmp_name"].</li>
                                    <li>size (integer): the $_FILE["example_file"]["size"].</li>
                                </ul>
                            <p>Example: $FileAPP->upload_file($file).</p>
                            <span>Will upload file based on the array passed parameters and will create downsized copies if FileAPP->make_thumbnail functions criterias are matched.</span>
                        </li>
                    </ul>