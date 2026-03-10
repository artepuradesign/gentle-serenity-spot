import { ChevronRight } from "lucide-react";

interface Props {
  faturaAtual: number;
  limiteDisponivel: number;
  showBalance: boolean;
  loading: boolean;
  formatCurrency: (v: number) => string;
}

const PainelCartao = ({ faturaAtual, limiteDisponivel, showBalance, loading, formatCurrency }: Props) => (
  <section className="px-5 py-5">
    <div className="flex items-center justify-between mb-1">
      <h3 className="text-lg text-foreground font-body">Cartão de crédito</h3>
      <ChevronRight className="h-5 w-5 text-muted-foreground" />
    </div>
    <p className="text-base text-muted-foreground font-body mt-1">Fatura atual</p>
    <p className="text-2xl font-bold text-foreground font-heading mt-2">
      {loading ? "Carregando..." : showBalance ? formatCurrency(faturaAtual) : "••••••"}
    </p>
    <p className="text-sm text-muted-foreground mt-2 font-body">
      Limite disponível de {showBalance ? formatCurrency(limiteDisponivel) : "••••••"}
    </p>
  </section>
);

export default PainelCartao;
