import { ChevronRight } from "lucide-react";
import { useNavigate } from "react-router-dom";

interface Props {
  saldo: number;
  showBalance: boolean;
  loading: boolean;
  formatCurrency: (v: number) => string;
}

const PainelSaldo = ({ saldo, showBalance, loading, formatCurrency }: Props) => {
  const navigate = useNavigate();

  return (
    <section className="px-5 py-5 cursor-pointer active:bg-muted/30 transition-colors" onClick={() => navigate("/saldo")}>
      <div className="flex items-center justify-between mb-1">
        <p className="text-lg text-foreground font-body">Saldo em Conta</p>
        <ChevronRight className="h-5 w-5 text-muted-foreground" />
      </div>
      <p className="text-2xl font-bold text-foreground font-heading mt-2">
        {loading ? "Carregando..." : showBalance ? formatCurrency(saldo) : "••••••"}
      </p>
    </section>
  );
};


export default PainelSaldo;