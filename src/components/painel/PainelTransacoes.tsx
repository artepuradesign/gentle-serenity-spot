import { ArrowDownLeft, ArrowUpRight } from "lucide-react";

interface Transacao {
  id: number;
  tipo: string;
  categoria: string;
  descricao: string;
  valor: string;
  data_transacao: string;
  beneficiario_nome: string | null;
}

interface Props {
  transacoes: Transacao[];
  showBalance: boolean;
  loading: boolean;
  formatCurrency: (v: number) => string;
}

const PainelTransacoes = ({ transacoes, showBalance, loading, formatCurrency }: Props) => {
  const formatDate = (dateStr: string) => {
    const date = new Date(dateStr);
    const today = new Date();
    if (date.toDateString() === today.toDateString()) return "Hoje";
    return date.toLocaleDateString("pt-BR", { day: "2-digit", month: "short" });
  };

  return (
    <section className="px-5 py-5">
      <h3 className="text-lg text-foreground font-body mb-4">Histórico</h3>
      {loading ? (
        <p className="text-sm text-muted-foreground font-body">Carregando...</p>
      ) : transacoes.length === 0 ? (
        <p className="text-sm text-muted-foreground font-body">Nenhum registro encontrado.</p>
      ) : (
        <div className="space-y-0">
          {transacoes.slice(0, 8).map((t) => (
            <div key={t.id}>
              <div className="flex items-start gap-3 py-3">
                <div className={`w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 ${t.tipo === "entrada" ? "bg-nu-green/10" : "bg-secondary"}`}>
                  {t.tipo === "entrada" ? (
                    <ArrowDownLeft className="h-5 w-5 text-nu-green" />
                  ) : (
                    <ArrowUpRight className="h-5 w-5 text-foreground" />
                  )}
                </div>
                <div className="flex-1 min-w-0">
                  <p className="text-sm text-foreground font-heading font-bold">
                    Transferência {t.tipo === "entrada" ? "recebida" : "enviada"}
                  </p>
                  <p className="text-sm text-muted-foreground font-body mt-0.5">
                    {t.beneficiario_nome || t.descricao}
                  </p>
                  <p className="text-sm text-muted-foreground font-body">
                    {showBalance
                      ? formatCurrency(parseFloat(t.valor))
                      : "••••••"}
                  </p>
                </div>
                <span className="text-xs text-muted-foreground font-body flex-shrink-0 pt-1">
                  {formatDate(t.data_transacao)}
                </span>
              </div>
              <div className="h-px bg-border" />
            </div>
          ))}
        </div>
      )}
    </section>
  );
};

export default PainelTransacoes;
