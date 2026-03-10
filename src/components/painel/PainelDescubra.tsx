const PainelDescubra = () => (
  <section className="px-5 py-6">
    <h3 className="text-base font-bold text-foreground font-heading mb-4">Descubra mais</h3>
    <div className="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
      <div className="min-w-[260px] rounded-2xl border border-border overflow-hidden">
        <div className="h-36 bg-secondary" />
        <div className="p-4">
          <h4 className="font-bold text-foreground font-heading text-sm">Conta para menores de 18</h4>
          <p className="text-xs text-muted-foreground mt-1 font-body">Solicite a conta para seus filhos a partir de 6 anos.</p>
          <button className="bg-primary text-primary-foreground text-xs font-semibold px-4 py-2 rounded-full mt-3 font-heading">
            Começar
          </button>
        </div>
      </div>
      <div className="min-w-[260px] rounded-2xl border border-border overflow-hidden">
        <div className="h-36 bg-secondary" />
        <div className="p-4">
          <h4 className="font-bold text-foreground font-heading text-sm">Seguro Vida</h4>
          <p className="text-xs text-muted-foreground mt-1 font-body">Cuide de quem você ama de um jeito simples pro seu bolso.</p>
          <button className="bg-primary text-primary-foreground text-xs font-semibold px-4 py-2 rounded-full mt-3 font-heading">
            Conhecer
          </button>
        </div>
      </div>
    </div>
  </section>
);

export default PainelDescubra;
