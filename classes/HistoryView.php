<?php

  class HistoryView implements IView {
    private $transactions = array();

    public function __construct() {
      $this->loadData();
    }

    public function getScripts() {
      return '';
    }

    public function getTitle() {
      return 'Transaction History';
    }

    private function loadData() {
      $db       = Database::getDB();
      $fields   = array('transactions.date', 'transactions.customer',
                        'transactions.description', 'transactions.netto',
                        'transactions.tax_7', 'transactions.tax_19',
                        'transactions.brutto',
                        'categories.name');
      $options  = 'ORDER BY date ASC';
      $join     = 'JOIN categories ON categories.id = transactions.category_id';
      $res      = $db->select('transactions', $fields,
                              null, $options, null, $join);

      if (count($res)) {
        foreach ($res as $row) {
          $this->transactions[] = array(
            'brutto'      => $row['brutto'],
            'category'    => $row['name'],
            'customer'    => $row['customer'],
            'date'        => $row['date'],
            'description' => $row['description'],
            'netto'       => $row['netto'],
            'tax_7'       => $row['tax_7'],
            'tax_19'      => $row['tax_19']
          );
        }
      }
    }

    public function show() {
      echo '<table class="value_list">';
      echo '<thead>';
      echo '<tr>';
      echo '<td class="date">Date</td>';
      echo '<td class="text">Customer</td>';
      echo '<td class="text">Description</td>';
      echo '<td class="number">Netto</td>';
      echo '<td class="number">7%</td>';
      echo '<td class="number">19%</td>';
      echo '<td class="number">Brutto</td>';
      echo '<td class="text">Category</td>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      if (!count($this->transactions)) {
        echo '<tr>';
        echo '<td colspan="8">No transactions</td>';
        echo '</tr>';

      } else {
        foreach ($this->transactions as $transaction) {
          echo '<tr>';
          echo '<td class="date">';
          echo date('d.m.Y', strtotime($transaction['date']));
          echo '</td>';
          echo '<td class="text">';
          echo $transaction['customer'];
          echo '</td>';
          echo '<td class="text">';
          echo $transaction['description'];
          echo '</td>';
          echo '<td class="number">';
          echo sprintf('%01.2f €', $transaction['netto']);
          echo '</td>';
          echo '<td class="number">';
          echo sprintf('%01.2f €', $transaction['tax_7']);
          echo '</td>';
          echo '<td class="number">';
          echo sprintf('%01.2f €', $transaction['tax_19']);
          echo '</td>';
          echo '<td class="number">';
          echo sprintf('%01.2f €', $transaction['brutto']);
          echo '</td>';
          echo '<td class="text">';
          echo $transaction['category'];
          echo '</td>';
          echo '</tr>';
        }
      }

      echo '</tbody>';
      echo '</table>';
    }
  }

?>