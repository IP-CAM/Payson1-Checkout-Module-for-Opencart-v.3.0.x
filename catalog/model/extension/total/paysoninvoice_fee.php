<?php
class ModelExtensionTotalPaysoninvoiceFee extends Model {
    
    public function getTotal($total) {

        if (isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'paysoninvoice' && $this->config->get('total_paysoninvoice_fee_fee') >= 0 && $this->session->data['payment_method']['code'] != 'paysondirect') {
            $this->load->language('extension/total/paysoninvoice_fee');
            $total['totals'][] = array(
                'code' => 'total_paysoninvoice_fee',
                'title' => $this->language->get('text_paysoninvoice_fee'),
                'text' => $this->currency->format($this->config->get('total_paysoninvoice_fee_fee')),
                'value' => $this->config->get('total_paysoninvoice_fee_fee'),
                    // 'sort_order' => $this->config->get('ptotal_aysoninvoice_fee_sort_order')
            );

            if ($this->config->get('total_paysoninvoice_fee_tax_class_id')) {
                $tax_rates = $this->tax->getRates($this->config->get('total_paysoninvoice_fee_fee'), $this->config->get('total_paysoninvoice_fee_tax_class_id'));

                foreach ($tax_rates as $tax_rate) {
                    if (!isset($total['taxes'][$tax_rate['tax_rate_id']])) {
                        $total['taxes'][$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    } else {
                        $total['taxes'][$tax_rate['tax_rate_id']] += $tax_rate['amount'];
                    }
                }
            }
            $total += $this->config->get('total_paysoninvoice_fee_fee');
        }
    }
    
}