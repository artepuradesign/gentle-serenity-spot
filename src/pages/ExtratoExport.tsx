import { useState, useEffect } from "react";
import { useSearchParams, useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { ArrowLeft, Printer } from "lucide-react";
import { apiGet } from "@/lib/api";
import logoNu from "@/assets/logonu.png";

const ExtratoExport = () => {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const contaId = searchParams.get("conta_id") || "";
  const dataInicio = searchParams.get("data_inicio") || "";
  const dataFim = searchParams.get("data_fim") || "";

  const [data, setData] = useState<any>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!contaId || !dataInicio || !dataFim) return;
    apiGet("extrato.php", { conta_id: contaId, data_inicio: dataInicio, data_fim: dataFim })
      .then(setData)
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [contaId, dataInicio, dataFim]);

  const fmt = (v: number) =>
    v.toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

  const handlePrint = () => window.print();

  if (loading) {
    return <div className="min-h-screen flex items-center justify-center text-muted-foreground">Carregando extrato...</div>;
  }

  if (!data) {
    return <div className="min-h-screen flex items-center justify-center text-muted-foreground">Erro ao carregar extrato.</div>;
  }

  const conta = data.conta || {};
  const resumo = data.resumo || {};
  const movimentacoes = data.movimentacoes || {};
  const datasOrdenadas = Object.keys(movimentacoes).sort();

  const fmtPeriodo = (d: string) =>
    new Date(d + "T12:00:00").toLocaleDateString("pt-BR", { day: "2-digit", month: "long", year: "numeric" }).toUpperCase();

  const fmtDia = (d: string) => {
    const dt = new Date(d + "T12:00:00");
    const day = String(dt.getDate()).padStart(2, "0");
    const months = ["JAN","FEV","MAR","ABR","MAI","JUN","JUL","AGO","SET","OUT","NOV","DEZ"];
    return `${day} ${months[dt.getMonth()]} ${dt.getFullYear()}`;
  };

  // Compute saldo do dia for each date
  const saldoPorDia: Record<string, number> = {};
  {
    let saldoAcumulado = resumo.saldo_inicial || 0;
    for (const dia of datasOrdenadas) {
      const trans = movimentacoes[dia];
      for (const t of trans) {
        if (t.tipo === "entrada") saldoAcumulado += parseFloat(t.valor);
        else saldoAcumulado -= parseFloat(t.valor);
      }
      saldoPorDia[dia] = saldoAcumulado;
    }
  }

  const pageStyle: React.CSSProperties = {
    fontFamily: "'Graphik', 'Helvetica Neue', Helvetica, Arial, sans-serif",
    fontWeight: 400,
    fontSize: "11px",
    lineHeight: "1.5",
    color: "#222",
  };

  return (
    <>
      <style>{`
        @media print {
          @page {
            margin: 3mm;
            size: A4;
          }
          body {
            margin: 0;
            padding: 0;
            counter-reset: page 0;
          }
          .print-footer {
            position: fixed;
            bottom: 8mm;
            left: 15mm;
            right: 15mm;
            padding: 12px 0 0 0;
            font-size: 8.5px;
            color: #888;
            line-height: 1.4;
            border-top: 2px solid #ccc;
            font-family: 'Graphik', sans-serif;
            font-weight: 400;
            counter-increment: page;
          }
          .print-footer .footer-date-page {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
          }
          .print-footer .footer-page-number::after {
            content: counter(page) " de " counter(pages);
          }
        }
        @media not print {
          .print-footer-screen {
            margin-top: 32px;
            border-top: 2px solid #ccc;
            padding-top: 16px;
            font-size: 9px;
            color: #888;
            line-height: 1.5;
            font-family: 'Graphik', sans-serif;
            font-weight: 400;
          }
        }
        @media print {
          .print-footer-screen {
            display: none !important;
          }
        }
      `}</style>

      {/* Print-only fixed footer on every page */}
      <div className="print-footer hidden print:block">
        <p>Tem alguma dúvida? Mande uma mensagem para nosso time de atendimento pelo chat do app ou ligue 4020 0185 (capitais e regiões metropolitanas) ou 0800 591 2117 (demais localidades). Atendimento 24h.</p>
        <p style={{ marginTop: "4px" }}>Caso a solução fornecida nos canais de atendimento não tenha sido satisfatória, fale com a Ouvidoria em 0800 887 0463 ou pelos meios disponíveis em nubank.com.br/contatos#ouvidoria. Atendimento das 8h às 18h em dias úteis.</p>
        <div className="footer-date-page">
          <span>Extrato gerado dia {new Date().toLocaleDateString("pt-BR", { day: "2-digit", month: "long", year: "numeric" })} às {new Date().toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" })}</span>
          <span className="footer-page-number"></span>
        </div>
      </div>

      <div className="print:hidden bg-secondary/30 border-b border-border px-6 py-4 flex items-center gap-4 sticky top-0 z-50">
        <Button variant="ghost" size="icon" onClick={() => navigate(-1)}>
          <ArrowLeft className="h-5 w-5" />
        </Button>
        <h1 className="text-lg font-bold text-foreground flex-1">Pré-visualização do Extrato</h1>
        <Button variant="hero" onClick={handlePrint}>
          <Printer className="h-4 w-4 mr-2" /> Imprimir / Salvar PDF
        </Button>
      </div>

      <div className="flex justify-center py-8 print:py-0 bg-secondary/30 print:bg-white min-h-screen">
        <div
          className="bg-white shadow-lg print:shadow-none w-[210mm] min-h-[297mm] px-[15mm] py-[20mm] print:w-full print:min-h-0 print:px-[15mm] print:pt-[12mm] print:pb-[50mm]"
          style={pageStyle}
        >
          {/* ===== HEADER ===== */}
          <div className="flex justify-between items-start mb-12">
            <img src={logoNu} alt="Nu" style={{ height: "32px", width: "auto" }} />
            <div className="text-right" style={{ fontSize: "12px", lineHeight: "1.6" }}>
              <p style={{ fontWeight: 400 }}>{conta.titular}</p>
              <p>
                <span style={{ fontWeight: 700, color: "#222" }}>{conta.tipo_conta === "PJ" ? "CNPJ" : "CPF"}</span>{"  "}{conta.documento}{"  "}
                <span style={{ fontWeight: 700 }}>Agência</span>{"  "}{conta.agencia || "0001"}{"  "}
                <span style={{ fontWeight: 700 }}>Conta</span>
              </p>
              <p>{conta.numero_conta}</p>
            </div>
          </div>

          {/* ===== PERÍODO ===== */}
          <div style={{ borderBottom: "2px solid #ccc", paddingBottom: "8px", marginBottom: "24px" }}>
            <div className="flex justify-between items-baseline">
              <span style={{ fontWeight: 700, fontSize: "12px" }}>
                {fmtPeriodo(dataInicio)} a {fmtPeriodo(dataFim)}
              </span>
              <span style={{ fontSize: "12px", color: "#666" }}>VALORES EM R$</span>
            </div>
          </div>

          {/* ===== RESUMO ===== */}
          <div className="flex justify-between items-start" style={{ marginBottom: "24px" }}>
            <div style={{ paddingTop: "8px" }}>
              <p style={{ fontSize: "11px", color: "#666", marginBottom: "6px", fontWeight: 700 }}>Saldo final do período</p>
              <p style={{ fontSize: "22px", fontWeight: 400, color: "#820AD1", lineHeight: "1.2" }}>
                R$ {fmt(resumo.saldo_final)}
              </p>
            </div>
            <table style={{ fontSize: "12px", borderCollapse: "collapse", minWidth: "320px" }}>
              <tbody>
                <tr>
                  <td style={{ fontWeight: 700, padding: "3px 16px 3px 0" }}>Saldo inicial</td>
                  <td style={{ textAlign: "right", padding: "3px 0" }}>{fmt(resumo.saldo_inicial)}</td>
                </tr>
                <tr>
                  <td style={{ padding: "3px 16px 3px 0", color: "#444" }}>Rendimento líquido</td>
                  <td style={{ textAlign: "right", padding: "3px 0" }}>+{fmt(resumo.rendimento_liquido)}</td>
                </tr>
                <tr>
                  <td style={{ padding: "3px 16px 3px 0", color: "#444" }}>Total de entradas</td>
                  <td style={{ textAlign: "right", padding: "3px 0" }}>+{fmt(resumo.total_entradas)}</td>
                </tr>
                <tr>
                  <td style={{ padding: "3px 16px 3px 0", color: "#444" }}>Total de saídas</td>
                  <td style={{ textAlign: "right", padding: "3px 0" }}>-{fmt(resumo.total_saidas)}</td>
                </tr>
                <tr>
                  <td style={{ fontWeight: 700, padding: "6px 16px 3px 0" }}>Saldo final do período</td>
                  <td style={{ fontWeight: 700, textAlign: "right", padding: "6px 0 3px 0" }}>{fmt(resumo.saldo_final)}</td>
                </tr>
              </tbody>
            </table>
          </div>

          {/* ===== MOVIMENTAÇÕES ===== */}
          <div style={{ borderBottom: "2px solid #ccc", marginBottom: "4px" }}></div>
          <div style={{ marginBottom: "16px" }}>
            <span style={{ fontWeight: 700, fontSize: "12px" }}>Movimentações</span>
          </div>

          {datasOrdenadas.length === 0 && (
            <p style={{ textAlign: "center", color: "#999", padding: "20px 0" }}>Nenhuma movimentação encontrada no período.</p>
          )}

          {datasOrdenadas.map(dia => {
            const trans = movimentacoes[dia];
            const entradas = trans.filter((t: any) => t.tipo === "entrada");
            const saidas = trans.filter((t: any) => t.tipo === "saida");
            const totalE = entradas.reduce((s: number, t: any) => s + parseFloat(t.valor), 0);
            const totalS = saidas.reduce((s: number, t: any) => s + parseFloat(t.valor), 0);
            let showDate = true;

            return (
              <div key={dia} style={{ marginBottom: "0" }}>
                <table style={{ width: "100%", borderCollapse: "collapse", fontSize: "11px" }}>
                  <tbody>
                    {/* Entradas */}
                    {entradas.length > 0 && (
                      <>
                        <tr>
                          <td style={{ width: "110px", verticalAlign: "top", padding: "10px 16px 10px 0", color: "#222" }}>{(() => { if (showDate) { showDate = false; return fmtDia(dia); } return ""; })()}</td>
                          <td style={{ fontWeight: 700, padding: "10px 0", verticalAlign: "top" }}>Total de entradas</td>
                          <td style={{ padding: "10px 0" }}></td>
                          <td style={{ fontWeight: 700, textAlign: "right", padding: "10px 0 10px 24px", whiteSpace: "nowrap", verticalAlign: "top" }}>+{fmt(totalE)}</td>
                        </tr>
                        {entradas.map((t: any, i: number) => (
                          <tr key={t.id || i}>
                            <td style={{ padding: "4px 16px 4px 0" }}></td>
                            <td style={{ padding: "4px 0", verticalAlign: "top", width: "200px" }}>
                              {t.descricao}
                            </td>
                            <td style={{ padding: "4px 8px", verticalAlign: "top", color: "#888", fontSize: "10px", lineHeight: "1.6" }}>
                              {t.beneficiario_nome} - {t.beneficiario_documento} - {t.beneficiario_banco} Agência: {t.beneficiario_agencia} Conta: {t.beneficiario_conta}
                            </td>
                            <td style={{ textAlign: "right", padding: "4px 0 4px 24px", verticalAlign: "top", whiteSpace: "nowrap" }}>{fmt(parseFloat(t.valor))}</td>
                          </tr>
                        ))}
                      </>
                    )}

                    {/* Saídas */}
                    {saidas.length > 0 && (
                      <>
                        <tr>
                          <td style={{ width: "110px", verticalAlign: "top", padding: "10px 16px 10px 0", color: "#222" }}>{(() => { if (showDate) { showDate = false; return fmtDia(dia); } return ""; })()}</td>
                          <td style={{ fontWeight: 700, padding: "10px 0", verticalAlign: "top" }}>Total de saídas</td>
                          <td style={{ padding: "10px 0" }}></td>
                          <td style={{ fontWeight: 700, textAlign: "right", padding: "10px 0 10px 24px", whiteSpace: "nowrap", verticalAlign: "top" }}>-{fmt(totalS)}</td>
                        </tr>
                        {saidas.map((t: any, i: number) => (
                          <tr key={t.id || i}>
                            <td style={{ padding: "4px 16px 4px 0" }}></td>
                            <td style={{ padding: "4px 0", verticalAlign: "top", width: "200px" }}>
                              {t.descricao}
                            </td>
                            <td style={{ padding: "4px 8px", verticalAlign: "top", color: "#888", fontSize: "10px", lineHeight: "1.6" }}>
                              {t.beneficiario_nome} - {t.beneficiario_documento} - {t.beneficiario_banco} Agência: {t.beneficiario_agencia} Conta: {t.beneficiario_conta}
                            </td>
                            <td style={{ textAlign: "right", padding: "4px 0 4px 24px", verticalAlign: "top", whiteSpace: "nowrap" }}>{fmt(parseFloat(t.valor))}</td>
                          </tr>
                        ))}
                      </>
                    )}

                    {/* Saldo do dia */}
                    <tr style={{ borderBottom: "2px solid #ccc" }}>
                      <td style={{ padding: "10px 16px 10px 0" }}></td>
                      <td style={{ fontWeight: 700, padding: "10px 0" }}>Saldo do dia</td>
                      <td style={{ padding: "10px 0" }}></td>
                      <td style={{ fontWeight: 700, textAlign: "right", padding: "10px 0 10px 24px" }}>{fmt(saldoPorDia[dia])}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            );
          })}

          {/* ===== ÚLTIMA PÁGINA: Disclaimer + Empresas ===== */}
          <div style={{ marginTop: "40px", pageBreakInside: "avoid" }}>
            <div style={{ borderTop: "1px solid #ddd", paddingTop: "16px", fontSize: "10px", color: "#555", lineHeight: "1.6" }}>
              <p>O saldo líquido corresponde ao total de depósitos e rendimentos em conta, não considerando movimentações feitas após a data mencionada.</p>
              <p>Não nos responsabilizamos pelo uso indevido ou por alterações das informações originalmente contidas neste documento após envio.</p>
              <p>Asseguramos a autenticidade destas movimentações e das informações aqui citadas.</p>
            </div>

            <div className="flex justify-between items-start" style={{ marginTop: "20px", fontSize: "10px", lineHeight: "1.6", color: "#222" }}>
              <div>
                <p style={{ fontWeight: 700 }}>Nu Financeira S.A. - Sociedade de Credito, Financiamento</p>
                <p style={{ fontWeight: 700 }}>e Investimento</p>
                <p>CNPJ: 30.680.829/0001-43</p>
              </div>
              <div style={{ textAlign: "right" }}>
                <p style={{ fontWeight: 700 }}>Nu Pagamentos S.A. - Instituição de Pagamento</p>
                <p>CNPJ: 18.236.120/0001-58</p>
              </div>
            </div>
          </div>

          {/* Screen-only footer */}
          <div className="print-footer-screen" style={{ marginTop: "32px" }}>
            <p>Tem alguma dúvida? Mande uma mensagem para nosso time de atendimento pelo chat do app ou ligue 4020 0185 (capitais e regiões metropolitanas) ou 0800 591 2117 (demais localidades). Atendimento 24h.</p>
            <p style={{ marginTop: "8px" }}>Caso a solução fornecida nos canais de atendimento não tenha sido satisfatória, fale com a Ouvidoria em 0800 887 0463 ou pelos meios disponíveis em nubank.com.br/contatos#ouvidoria. Atendimento das 8h às 18h em dias úteis.</p>
            <div className="flex justify-between" style={{ marginTop: "12px" }}>
              <span>Extrato gerado dia {new Date().toLocaleDateString("pt-BR", { day: "2-digit", month: "long", year: "numeric" })} às {new Date().toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" })}</span>
              <span>1 de 1</span>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default ExtratoExport;