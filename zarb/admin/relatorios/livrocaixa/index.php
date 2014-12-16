<form method="post" action="relatorios/livrocaixa/relatorio.php" target="blank">
  <h1>Relat&oacute;rio</h1>
  <label>De</label><input type='text' name='data_ini' class='data' maxlength='10' id='data' /> <font class="label3">a</font>
  <input type='text' name='data_fim' id='data2' class='data' maxlength='10' /><br /><br />
  <label>Tipo</label>
  <select name="tipo" class='campo'>
    <option value=''>Todas</option>
    <option value='E'>Entradas</option>
    <option value='S'>Sa&iacute;das</option>
  </select><br /><br />
  <input type="submit" value="Gerar" class="botao">
  </form>