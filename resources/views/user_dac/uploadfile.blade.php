<style type="text/css">
  /*uploads css*/
  input[type=file] {
    cursor: pointer;
    width: 100%;
    height: 42px;
    overflow: hidden;
    color:transparent;
  }

  input[type=file]:before {
    width: 100%;
    height: 38px;
    font-size: 16px;
    color:#007bff;
    line-height: 32px;
    content: 'Select files to be uploaded';
    display: inline-block;
    background: white;
    border: 2px solid #007bff;
    border-radius: 26px;
    text-align: center;
    font-family: Helvetica, Arial, sans-serif;
  }

  input[type=file]::-webkit-file-upload-button {
    visibility: hidden !important;
  }
</style>