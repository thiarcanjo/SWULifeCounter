<?php
require_once __DIR__.'/../UTILS/autoload.php';
use \SQL\Entity\Premier;
use \SQL\Entity\Aspect;
use \SQL\Entity\Card;
use \SQL\Entity\Collection;
use \UTILS\Session;
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);

$response = ['status' => 'ocr_empty', 
            'data' => null, 
            'message' => 'Texto OCR vazio.', 
            'extracted_name_attempt' => ''];

if (isset($_POST['textOCR'])) {
    $textOCR = $_POST['textOCR'];

    $response = CardRecon($textOCR);
}

// Função de reconhecimento real (ESBOÇO - MUITO COMPLEXO)
function CardRecon($textOCR) {
    error_log("Texto OCR: " . $textOCR);

    if (empty(trim($textOCR))) {
        return ['status' => 'ocr_empty', 'data' => null, 'message' => 'Texto OCR vazio.', 'extracted_name_attempt' => ''];
    }

    // 1. Pré-processamento básico do texto OCR
    $cleaned_text = strtoupper(trim($textOCR));
    $cleaned_text = preg_replace('/\s+/', ' ', $cleaned_text); // Normaliza múltiplos espaços

    // Tenta remover símbolos comuns de líder (❖, ♦, etc.) e outros caracteres não alfanuméricos no início da linha
    // que o OCR pode ter pego antes do nome. \p{L} para letras Unicode, \p{N} para números.
    $cleaned_text = preg_replace('/^[^a-zA-Z0-9]+/', '', $cleaned_text);
    $cleaned_text = trim($cleaned_text);

    error_log("PHP CardReconByName: Texto OCR limpo para extração do nome: ---" . $cleaned_text . "---");

    $potential_card_name = null;
    
    // 2. Extrair o nome da carta
    // Heurística: O nome da carta é geralmente a primeira linha significativa de texto toda em MAIÚSCULAS.
    // Se o Tesseract.js retornar o texto com quebras de linha (\n), pegamos a primeira.
    $lines = explode("\n", $cleaned_text);
    $main_name_line = '';
    if (!empty($lines)) {
        foreach ($lines as $line) {
            $trimmed_line = trim($line);
            // Considera uma linha significativa se tiver mais de 2 caracteres e começar com letra ou número
            if (strlen($trimmed_line) > 2 && preg_match('/^[A-Z0-9]/', $trimmed_line)) {
                $main_name_line = $trimmed_line;
                break; 
            }
        }
    }

    if (empty($main_name_line)) {
        // Se não houver quebras de linha ou linhas significativas, usa o texto limpo como um todo
        // desde que comece com letra/número.
        if (strlen($cleaned_text) > 2 && preg_match('/^[A-Z0-9]/', $cleaned_text)) {
            $main_name_line = $cleaned_text;
        }
    }

    if (empty($main_name_line)) {
        error_log("PHP CardRecon: Nenhuma linha de nome significativa encontrada no OCR.");
        $return_payload['status'] = 'name_line_not_found';
        $return_payload['message'] = 'Nenhuma linha de nome significativa encontrada no OCR.';
        $return_payload['extracted_name_attempt'] = $main_name_line;
        return $return_payload;
    }

    error_log("PHP CardRecon: Linha candidata ao nome: ---" . $main_name_line . "---");

    // Primeiro, vamos pegar tudo que parece um nome antes de um possível código de carta no final da linha.
    $name_candidate_before_code = preg_replace('/\s+([A-Z]{3}[- ]?[A-Z]{2}\s*[A-Z]?\s*\d{2,3}.*)$/', '', $main_name_line);
    $name_candidate_before_code = trim($name_candidate_before_code);

    if (preg_match('/^([A-Z0-9][A-Z0-9\s\'\-\.]*[A-Z0-9])/', $name_candidate_before_code, $name_match)) {
        $potential_card_name = trim($name_match[1]);
        // Remove múltiplos espaços internos que a regex pode ter permitido
        $potential_card_name = preg_replace('/\s+/', ' ', $potential_card_name);
    }

    $potential_card_name = trim($potential_card_name); // Limpeza final
    $return_payload['extracted_name_attempt'] = $potential_card_name;
    error_log("PHP CardRecon: Candidato a nome final extraído: ---" . $potential_card_name . "---");

    if ($potential_card_name && strlen($potential_card_name) >= 3) { // Nome deve ter um tamanho mínimo
        try {
            $cardEntity = new Card();
            $Cards = $cardEntity->getByName($potential_card_name);

            if ($Cards) {
                foreach($Cards as $Card){
                    error_log("Nome encontrado: " . $potential_card_name . " -> CODE: " . $Card->getCode());
                    error_log("CARD: ".print_r($Card, true));
                }
                
                return ['status' => 'success', 'data' => $Cards, 'message' => 'Carta(s) encontrada(s)', 'extracted_name_attempt' => $potential_card_name];
            }
            else {
                error_log("PHP CardReconByName: Nome '" . $potential_card_name . "' não encontrado no banco de dados.");
                return ['status' => 'db_name_not_found', 'data' => null, 'message' => 'Nome da carta não encontrado no banco.', 'extracted_name_attempt' => $potential_card_name];
            }
        }
        catch (Exception $e) {
            error_log("PHP CardReconByName: Erro de banco de dados ao buscar por nome: " . $e->getMessage());
            return ['status' => 'db_error', 'data' => null, 'message' => 'Erro de banco de dados: ' . $e->getMessage(), 'extracted_name_attempt' => $potential_card_name];
        }
    }
    else {
        error_log("PHP CardReconByName: Nenhum nome de carta válido pôde ser extraído do texto OCR: " . $textOCR);
        return ['status' => 'name_extraction_failed', 'data' => null, 'message' => 'Não foi possível extrair um nome de carta válido do texto.', 'extracted_name_attempt' => $potential_card_name];
    }
}

echo json_encode($response);
exit;
?>